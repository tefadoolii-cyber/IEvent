<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompaniesImport implements ToCollection, WithHeadingRow
{
    public array $errors   = [];
    public int   $imported = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $rowNum = $i + 2;

            if (empty($row['name'])) {
                $this->errors[] = "الصف {$rowNum}: اسم الشركة مطلوب";
                continue;
            }

            Company::create([
                'name'    => $row['name'],
                'email'   => $row['email']   ?? null,
                'phone'   => $row['phone']   ?? null,
                'address' => $row['address'] ?? null,
            ]);

            $this->imported++;
        }
    }
}
