<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Employee;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $query = Shift::withCount('employees');
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $shifts = $query->latest()->paginate(15)->withQueryString();
        return view('shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('shifts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'start_time' => 'required',
            'end_time'   => 'required',
            'days'       => 'nullable|array',
            'days.*'     => 'in:sat,sun,mon,tue,wed,thu,fri',
            'notes'      => 'nullable|string',
        ]);
        Shift::create($request->all());
        return redirect()->route('shifts.index')->with('success', 'تم إضافة الوردية');
    }

    public function show(Shift $shift)
    {
        $shift->load('employees');
        $allEmployees = Employee::where('status', 'active')
                                ->whereNotIn('id', $shift->employees->pluck('id'))
                                ->get();
        return view('shifts.show', compact('shift', 'allEmployees'));
    }

    public function edit(Shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'start_time' => 'required',
            'end_time'   => 'required',
            'days'       => 'nullable|array',
            'days.*'     => 'in:sat,sun,mon,tue,wed,thu,fri',
            'notes'      => 'nullable|string',
        ]);
        $shift->update($request->all());
        return redirect()->route('shifts.index')->with('success', 'تم تعديل الوردية');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index')->with('success', 'تم حذف الوردية');
    }

    public function addEmployee(Request $request, Shift $shift)
    {
        $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'effective_date' => 'nullable|date',
        ]);
        $shift->employees()->syncWithoutDetaching([
            $request->employee_id => ['effective_date' => $request->effective_date],
        ]);
        return redirect()->back()->with('success', 'تم تعيين الوردية للموظف');
    }

    public function removeEmployee(Shift $shift, Employee $employee)
    {
        $shift->employees()->detach($employee->id);
        return redirect()->back()->with('success', 'تم إزالة الموظف من الوردية');
    }
}
