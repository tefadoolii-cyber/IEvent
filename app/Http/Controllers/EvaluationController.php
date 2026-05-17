<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Employee;
use App\Models\LookupGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $query = Evaluation::with(['employee', 'evaluator']);

        if ($request->search) {
            $query->whereHas('employee', fn($q) => $q->where('name', 'like', '%'.$request->search.'%'));
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->period) {
            $query->where('period', $request->period);
        }

        $evaluations = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'     => Evaluation::count(),
            'draft'     => Evaluation::where('status','draft')->count(),
            'submitted' => Evaluation::where('status','submitted')->count(),
            'approved'  => Evaluation::where('status','approved')->count(),
            'avg_score' => round(Evaluation::avg('total_score') ?? 0, 1),
        ];

        return view('evaluations.index', compact('evaluations', 'stats'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        $criteria  = LookupGroup::where('key', 'evaluation_criteria')->first()?->lookups ?? collect();
        return view('evaluations.create', compact('employees', 'criteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period'      => 'required|string|max:20',
            'criteria'    => 'nullable|array',
            'total_score' => 'required|numeric|min:0|max:100',
            'status'      => 'required|in:draft,submitted,approved',
            'notes'       => 'nullable|string',
        ]);

        Evaluation::create(array_merge($request->all(), ['evaluator_id' => Auth::id()]));

        return redirect()->route('evaluations.index')->with('success', 'تم إضافة التقييم');
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['employee', 'evaluator']);
        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        $employees = Employee::where('status', 'active')->get();
        $criteria  = LookupGroup::where('key', 'evaluation_criteria')->first()?->lookups ?? collect();
        return view('evaluations.edit', compact('evaluation', 'employees', 'criteria'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period'      => 'required|string|max:20',
            'criteria'    => 'nullable|array',
            'total_score' => 'required|numeric|min:0|max:100',
            'status'      => 'required|in:draft,submitted,approved',
            'notes'       => 'nullable|string',
        ]);

        $evaluation->update($request->all());

        return redirect()->route('evaluations.index')->with('success', 'تم تعديل التقييم');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')->with('success', 'تم حذف التقييم');
    }
}
