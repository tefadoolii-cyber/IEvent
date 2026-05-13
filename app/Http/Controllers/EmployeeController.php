<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    // عرض كل الموظفين
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    // صفحة إضافة موظف
    public function create()
    {
        $customFields = CustomField::forTable('employees');
        return view('employees.create', compact('customFields'));
    }

    // حفظ الموظف الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'employee_number' => 'required|unique:employees',
        ]);

        // حفظ الموظف
        $employee = Employee::create($request->except('custom_fields'));

        // حفظ قيم الحقول المخصصة
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $fieldId => $value) {
                DB::table('custom_field_values')->insert([
                    'custom_field_id' => $fieldId,
                    'record_table'    => 'employees',
                    'record_id'       => $employee->id,
                    'value'           => $value,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }

        return redirect()->route('employees.index')->with('success', 'تم إضافة الموظف بنجاح');
    }

    // تعديل موظف
    public function edit(Employee $employee)
    {
        $customFields = CustomField::forTable('employees');

        // جلب القيم المحفوظة
        $customValues = DB::table('custom_field_values')
            ->where('record_table', 'employees')
            ->where('record_id', $employee->id)
            ->pluck('value', 'custom_field_id')
            ->toArray();

        return view('employees.edit', compact('employee', 'customFields', 'customValues'));
    }

    // حفظ التعديل
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'            => 'required',
            'employee_number' => 'required|unique:employees,employee_number,' . $employee->id,
        ]);

        $employee->update($request->except('custom_fields'));

        // تحديث قيم الحقول المخصصة
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $fieldId => $value) {
                DB::table('custom_field_values')->updateOrInsert(
                    [
                        'custom_field_id' => $fieldId,
                        'record_table'    => 'employees',
                        'record_id'       => $employee->id,
                    ],
                    [
                        'value'      => $value,
                        'updated_at' => now(),
                    ]
                );
            }
        }

        return redirect()->route('employees.index')->with('success', 'تم تعديل الموظف بنجاح');
    }

    // حذف موظف
    public function destroy(Employee $employee)
    {
        // حذف قيم الحقول المخصصة أولاً
        DB::table('custom_field_values')
            ->where('record_table', 'employees')
            ->where('record_id', $employee->id)
            ->delete();

        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'تم حذف الموظف');
    }
}