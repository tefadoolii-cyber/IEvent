<?php

namespace App\Http\Controllers;

use App\Models\ReadinessLicense;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadinessLicenseController extends Controller
{
    public function index(Request $request)
    {
        $query = ReadinessLicense::with(['employee', 'issuer']);

        if ($request->search) {
            $query->whereHas('employee', fn($q) => $q->where('name', 'like', '%'.$request->search.'%'));
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $licenses = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'     => ReadinessLicense::count(),
            'active'    => ReadinessLicense::where('status','active')->count(),
            'expired'   => ReadinessLicense::where('status','expired')->count(),
            'withdrawn' => ReadinessLicense::where('status','withdrawn')->count(),
        ];

        return view('readiness-licenses.index', compact('licenses', 'stats'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('readiness-licenses.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'issued_at'   => 'required|date',
            'expires_at'  => 'nullable|date|after:issued_at',
            'notes'       => 'nullable|string',
        ]);

        ReadinessLicense::create(array_merge($request->all(), [
            'issued_by' => Auth::id(),
            'status'    => 'active',
        ]));

        return redirect()->route('readiness-licenses.index')->with('success', 'تم إصدار رخصة الجاهزية');
    }

    public function show(ReadinessLicense $readinessLicense)
    {
        $readinessLicense->load(['employee', 'issuer', 'withdrawer']);
        return view('readiness-licenses.show', compact('readinessLicense'));
    }

    public function destroy(ReadinessLicense $readinessLicense)
    {
        $readinessLicense->delete();
        return redirect()->route('readiness-licenses.index')->with('success', 'تم حذف الرخصة');
    }

    public function withdraw(Request $request, ReadinessLicense $readinessLicense)
    {
        $request->validate(['withdrawal_reason' => 'required|string']);

        $readinessLicense->update([
            'status'            => 'withdrawn',
            'withdrawn_by'      => Auth::id(),
            'withdrawn_at'      => now(),
            'withdrawal_reason' => $request->withdrawal_reason,
        ]);

        return redirect()->back()->with('success', 'تم سحب رخصة الجاهزية');
    }
}
