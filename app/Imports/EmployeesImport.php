<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToCollection, WithHeadingRow
{
    public array $errors  = [];
    public int   $imported = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $rowNum = $i + 2;

            if (empty($row['name']) || empty($row['employee_number'])) {
                $this->errors[] = "الصف {$rowNum}: اسم الموظف ورقم الموظف مطلوبان";
                continue;
            }

            if (Employee::where('employee_number', $row['employee_number'])->exists()) {
                $this->errors[] = "الصف {$rowNum}: رقم الموظف '{$row['employee_number']}' موجود مسبقاً";
                continue;
            }

            Employee::create([
                'name'            => $row['name'],
                'employee_number' => $row['employee_number'],
                'email'           => $row['email']      ?? null,
                'phone'           => $row['phone']      ?? null,
                'department'      => $row['department']  ?? null,
                'position'        => $row['position']    ?? null,
                'hire_date'       => $row['hire_date']   ?? null,
                'status'          => $row['status']      ?? 'active',
            ]);

            $this->imported++;
        }
    }
}
