<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TasksReportExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(private Collection $tasks) {}

    public function collection(): Collection
    {
        return $this->tasks->map(fn($t) => [
            $t->title,
            $t->employee?->name ?? '—',
            $t->status,
            $t->priority     ?? '—',
            $t->due_date     ?? '—',
            $t->completed_at ?? '—',
        ]);
    }

    public function headings(): array
    {
        return ['المهمة', 'الموظف', 'الحالة', 'الأولوية', 'تاريخ الاستحقاق', 'تاريخ الإنجاز'];
    }

    public function title(): string
    {
        return 'تقرير المهام';
    }
}
