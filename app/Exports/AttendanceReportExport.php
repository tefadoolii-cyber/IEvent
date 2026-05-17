<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceReportExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        private Collection $data,
        private string $month
    ) {}

    public function collection(): Collection
    {
        return $this->data->map(fn($row) => [
            $row['employee']?->name          ?? '—',
            $row['employee']?->employee_number ?? '—',
            $row['present'],
            $row['absent'],
            $row['late'],
            $row['total'],
        ]);
    }

    public function headings(): array
    {
        return ['الموظف', 'رقم الموظف', 'حضور', 'غياب', 'تأخر', 'الإجمالي'];
    }

    public function title(): string
    {
        return "حضور {$this->month}";
    }
}
