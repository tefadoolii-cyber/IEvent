<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class EvaluationsReportExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(private Collection $evaluations) {}

    public function collection(): Collection
    {
        return $this->evaluations->map(fn($e) => [
            $e->employee?->name ?? '—',
            $e->period,
            $e->total_score,
            $e->status,
            $e->created_at->format('Y-m-d'),
        ]);
    }

    public function headings(): array
    {
        return ['الموظف', 'الفترة', 'الدرجة الكلية', 'الحالة', 'التاريخ'];
    }

    public function title(): string
    {
        return 'تقرير التقييمات';
    }
}
