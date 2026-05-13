<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // عرض كل سجلات الحضور
    public function index()
    {
        $attendance = Attendance::with('employee')->latest()->paginate(10);
        return view('attendance.index', compact('attendance'));
    }

    // صفحة تسجيل حضور
    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('attendance.create', compact('employees'));
    }

    // حفظ الحضور
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'date'        => 'required|date',
            'status'      => 'required',
        ]);

        Attendance::create($request->all());
        return redirect()->route('attendance.index')->with('success', 'تم تسجيل الحضور بنجاح');
    }

    // تعديل
    public function edit(Attendance $attendance)
    {
        $employees = Employee::where('status', 'active')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    // حفظ التعديل
    public function update(Request $request, Attendance $attendance)
    {
       $request->validate([
    'employee_id' => 'required',
    'date'        => 'required|date',
    'check_in'    => 'required',
    'status'      => 'required',
]);

        $attendance->update($request->all());
        return redirect()->route('attendance.index')->with('success', 'تم تعديل الحضور بنجاح');
    }

    // حذف
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'تم حذف السجل');
    }
}
