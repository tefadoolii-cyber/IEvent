<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = Contract::with('employee');

        if ($request->search) {
            $query->where('contract_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('employee', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $contracts = $query->latest()->paginate(15)->withQueryString();
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('contracts.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after:start_date',
            'salary'      => 'nullable|numeric|min:0',
            'position'    => 'nullable|string|max:255',
            'terms'       => 'nullable|string',
            'status'      => 'required|in:draft,sent,signed,cancelled',
            'pdf_file'    => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->except('pdf_file');
        $data['contract_number'] = 'CNT-' . strtoupper(Str::random(8));

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('contracts', 'public');
        }

        Contract::create($data);

        return redirect()->route('contracts.index')->with('success', 'تم إضافة العقد بنجاح');
    }

    public function show(Contract $contract)
    {
        $contract->load('employee');
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $employees = Employee::where('status', 'active')->get();
        return view('contracts.edit', compact('contract', 'employees'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after:start_date',
            'salary'      => 'nullable|numeric|min:0',
            'position'    => 'nullable|string|max:255',
            'terms'       => 'nullable|string',
            'status'      => 'required|in:draft,sent,signed,cancelled',
            'pdf_file'    => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $updateData = $request->except(['pdf_file', 'signed_at']);
        if ($request->status === 'signed' && !$contract->signed_at) {
            $updateData['signed_at'] = now();
        }

        if ($request->hasFile('pdf_file')) {
            if ($contract->pdf_file) {
                Storage::disk('public')->delete($contract->pdf_file);
            }
            $updateData['pdf_file'] = $request->file('pdf_file')->store('contracts', 'public');
        }

        $contract->update($updateData);

        return redirect()->route('contracts.index')->with('success', 'تم تعديل العقد بنجاح');
    }

    public function destroy(Contract $contract)
    {
        if ($contract->pdf_file) {
            Storage::disk('public')->delete($contract->pdf_file);
        }
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'تم حذف العقد');
    }

    public function sign(Request $request, Contract $contract)
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        if ($contract->status === 'cancelled') {
            return redirect()->back()->with('error', 'لا يمكن توقيع عقد ملغي');
        }

        $contract->update([
            'signature' => $request->signature,
            'signed_at' => now(),
            'status'    => 'signed',
        ]);

        return redirect()->back()->with('success', 'تم توقيع العقد بنجاح');
    }

    public function pdf(Contract $contract)
    {
        $contract->load('employee');
        $pdf = Pdf::loadView('contracts.pdf', compact('contract'))
                  ->setPaper('a4')
                  ->setOption('isHtml5ParserEnabled', true)
                  ->setOption('isRemoteEnabled', false);

        return $pdf->download('contract-' . $contract->contract_number . '.pdf');
    }
}
