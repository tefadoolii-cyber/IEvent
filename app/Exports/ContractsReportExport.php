<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ContractsReportExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(private Collection $contracts) {}

    public function collection(): Collection
    {
        return $this->contracts->map(fn($c) => [
            $c->employee?->name ?? '—',
            $c->type ?? '—',
            $c->start_date ?? '—',
            $c->end_date   ?? '—',
            $c->status,
            $c->salary ?? '—',
        ]);
    }

    public function headings(): array
    {
        return ['الموظف', 'نوع العقد', 'تاريخ البداية', 'تاريخ الانتهاء', 'الحالة', 'الراتب'];
    }

    public function title(): string
    {
        return 'تقرير العقود';
    }
}
