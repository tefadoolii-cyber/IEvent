<?php

namespace App\Http\Controllers;

use App\Imports\EmployeesImport;
use App\Imports\CompaniesImport;
use App\Imports\LocationsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return view('imports.index');
    }

    public function employees(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], ['file.required' => 'يرجى اختيار ملف', 'file.mimes' => 'يجب أن يكون الملف xlsx أو xls أو csv']);

        $import = new EmployeesImport();
        Excel::import($import, $request->file('file'));

        $msg = "تم استيراد {$import->imported} موظف بنجاح";
        if ($import->errors) {
            return redirect()->back()
                ->with('success', $msg)
                ->with('import_errors', $import->errors);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function companies(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], ['file.required' => 'يرجى اختيار ملف', 'file.mimes' => 'يجب أن يكون الملف xlsx أو xls أو csv']);

        $import = new CompaniesImport();
        Excel::import($import, $request->file('file'));

        $msg = "تم استيراد {$import->imported} شركة بنجاح";
        if ($import->errors) {
            return redirect()->back()
                ->with('success', $msg)
                ->with('import_errors', $import->errors);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function locations(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], ['file.required' => 'يرجى اختيار ملف', 'file.mimes' => 'يجب أن يكون الملف xlsx أو xls أو csv']);

        $import = new LocationsImport();
        Excel::import($import, $request->file('file'));

        $msg = "تم استيراد {$import->imported} موقع بنجاح";
        if ($import->errors) {
            return redirect()->back()
                ->with('success', $msg)
                ->with('import_errors', $import->errors);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function downloadTemplate(string $type)
    {
        $templates = [
            'employees' => [
                'headers' => ['name', 'employee_number', 'email', 'phone', 'department', 'position', 'hire_date', 'status'],
                'example' => ['أحمد محمد', 'EMP001', 'ahmed@example.com', '0501234567', 'IT', 'مطور', '2024-01-01', 'active'],
                'filename' => 'employees_template.csv',
            ],
            'companies' => [
                'headers' => ['name', 'email', 'phone', 'address'],
                'example' => ['شركة النجوم', 'info@company.com', '0112345678', 'الرياض - حي العليا'],
                'filename' => 'companies_template.csv',
            ],
            'locations' => [
                'headers' => ['name', 'address', 'lat', 'lng'],
                'example' => ['مقر الرياض', 'الرياض - طريق الملك فهد', '24.7136', '46.6753'],
                'filename' => 'locations_template.csv',
            ],
        ];

        if (!isset($templates[$type])) abort(404);

        $t    = $templates[$type];
        $rows = implode("\n", [
            implode(',', $t['headers']),
            implode(',', $t['example']),
        ]);

        return response($rows, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $t['filename'] . '"',
        ]);
    }
}
