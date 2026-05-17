@extends('layouts.app')
@section('title', 'التقييمات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-star"></i> تقييمات الموظفين</h4>
    <a href="{{ route('evaluations.create') }}" class="btn btn-add"><i class="bi bi-plus-lg"></i> تقييم جديد</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

{{-- إحصائيات --}}
<div class="row g-3 mb-4">
    @foreach([
        ['val'=>$stats['total'],     'label'=>'إجمالي',   'color'=>'#374151','bg'=>'#f3f4f6'],
        ['val'=>$stats['draft'],     'label'=>'مسودة',    'color'=>'#d97706','bg'=>'#fef3c7'],
        ['val'=>$stats['submitted'], 'label'=>'مُقدَّم',  'color'=>'#2563eb','bg'=>'#dbeafe'],
        ['val'=>$stats['approved'],  'label'=>'معتمد',    'color'=>'#16a34a','bg'=>'#dcfce7'],
        ['val'=>$stats['avg_score'], 'label'=>'متوسط الدرجة','color'=>'#7c3aed','bg'=>'#ede9fe'],
    ] as $s)
    <div class="col-6 col-md">
        <div class="card" style="text-align:center;padding:14px 10px;border-right:4px solid {{ $s['color'] }}">
            <div style="font-size:24px;font-weight:800;color:{{ $s['color'] }}">{{ $s['val'] }}</div>
            <div style="font-size:12px;color:#9ca3af">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="اسم الموظف..." value="{{ request('search') }}" style="font-size:13px">
        </div>
        <div class="col-md-2">
            <input type="text" name="period" class="form-control" placeholder="الفترة (2026-Q1)" value="{{ request('period') }}" style="font-size:13px">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="draft"     {{ request('status')=='draft'     ?'selected':'' }}>مسودة</option>
                <option value="submitted" {{ request('status')=='submitted' ?'selected':'' }}>مُقدَّم</option>
                <option value="approved"  {{ request('status')=='approved'  ?'selected':'' }}>معتمد</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        @if(request()->hasAny(['search','period','status']))
        <div class="col-auto"><a href="{{ route('evaluations.index') }}" class="btn btn-back" style="font-size:13px">مسح</a></div>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($evaluations->count())
        <table class="table mb-0">
            <thead>
                <tr><th>الموظف</th><th>الفترة</th><th>المُقيِّم</th><th>الدرجة</th><th>الحالة</th><th>التاريخ</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($evaluations as $eval)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $eval->employee->name }}</div>
                        <div style="font-size:11px;color:#9ca3af">{{ $eval->employee->department }}</div>
                    </td>
                    <td style="font-size:13px;font-family:monospace">{{ $eval->period }}</td>
                    <td style="font-size:13px">{{ $eval->evaluator->name }}</td>
                    <td>
                        <span style="font-size:15px;font-weight:800;color:{{ $eval->score_color }}">{{ $eval->total_score }}</span>
                        <span style="font-size:11px;color:#9ca3af">/100</span>
                    </td>
                    <td>
                        @php
                            $sc=['draft'=>'#d97706','submitted'=>'#2563eb','approved'=>'#16a34a'];
                            $sb=['draft'=>'#fef3c7','submitted'=>'#dbeafe','approved'=>'#dcfce7'];
                        @endphp
                        <span style="background:{{ $sb[$eval->status]??'#f3f4f6' }};color:{{ $sc[$eval->status]??'#6b7280' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $eval->status_label }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#9ca3af">{{ $eval->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="{{ route('evaluations.show', $eval->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('evaluations.edit', $eval->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('evaluations.destroy', $eval->id) }}" method="POST" onsubmit="return confirm('حذف هذا التقييم؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px">{{ $evaluations->withQueryString()->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-star" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد تقييمات</p>
        </div>
        @endif
    </div>
</div>
@endsection
