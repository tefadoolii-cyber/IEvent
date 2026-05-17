<?php

namespace App\Imports;

use App\Models\Location;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationsImport implements ToCollection, WithHeadingRow
{
    public array $errors   = [];
    public int   $imported = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $rowNum = $i + 2;

            if (empty($row['name'])) {
                $this->errors[] = "الصف {$rowNum}: اسم الموقع مطلوب";
                continue;
            }

            Location::create([
                'name'    => $row['name'],
                'address' => $row['address'] ?? null,
                'lat'     => $row['lat']     ?? null,
                'lng'     => $row['lng']     ?? null,
            ]);

            $this->imported++;
        }
    }
}
