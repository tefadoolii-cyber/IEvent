@extends('layouts.app')
@section('title', 'تقرير التقييمات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-star-half"></i> تقرير التقييمات</h4>
    <a href="{{ route('reports.index') }}" class="btn btn-back">رجوع</a>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <select name="period" class="form-select" style="font-size:13px">
                <option value="">كل الفترات</option>
                @foreach($periods as $p)
                <option value="{{ $p }}" {{ $period==$p?'selected':'' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> عرض</button>
        </div>
        <div class="col-auto">
            <a href="{{ request()->fullUrlWithQuery(['export'=>'excel']) }}" class="btn" style="background:#16a34a;color:white;font-size:13px;padding:8px 16px">
                <i class="bi bi-file-earmark-excel"></i> تصدير Excel
            </a>
        </div>
    </form>
</div>

@if($avgScore)
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid #d97706">
            <div style="font-size:26px;font-weight:800;color:#d97706">{{ $evaluations->count() }}</div>
            <div style="font-size:12px;color:#9ca3af">عدد التقييمات</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid #3b82f6">
            <div style="font-size:26px;font-weight:800;color:#3b82f6">{{ number_format($avgScore, 1) }}</div>
            <div style="font-size:12px;color:#9ca3af">متوسط الدرجات</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid #16a34a">
            <div style="font-size:26px;font-weight:800;color:#16a34a">{{ $evaluations->where('status','approved')->count() }}</div>
            <div style="font-size:12px;color:#9ca3af">معتمد</div>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-body p-0">
        @if($evaluations->count())
        <table class="table mb-0">
            <thead>
                <tr><th>الموظف</th><th>الفترة</th><th>الدرجة</th><th>الحالة</th><th>التاريخ</th></tr>
            </thead>
            <tbody>
                @foreach($evaluations as $ev)
                @php
                    $sc = $ev->total_score >= 80 ? '#16a34a' : ($ev->total_score >= 60 ? '#d97706' : '#dc2626');
                @endphp
                <tr>
                    <td style="font-weight:600;font-size:13px">{{ $ev->employee?->name ?? '—' }}</td>
                    <td style="font-size:13px">{{ $ev->period }}</td>
                    <td>
                        <span style="font-weight:700;font-size:15px;color:{{ $sc }}">{{ $ev->total_score }}</span>
                        <span style="font-size:11px;color:#9ca3af">/100</span>
                    </td>
                    <td>
                        <span style="font-size:11px;padding:3px 8px;border-radius:12px;font-weight:600;
                            background:{{ $ev->status==='approved'?'#dcfce7':($ev->status==='submitted'?'#eff6ff':'#f3f4f6') }};
                            color:{{ $ev->status==='approved'?'#16a34a':($ev->status==='submitted'?'#3b82f6':'#6b7280') }}">
                            {{ ['draft'=>'مسودة','submitted'=>'مُرسل','approved'=>'معتمد'][$ev->status] ?? $ev->status }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#9ca3af">{{ $ev->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-star" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد تقييمات</p>
        </div>
        @endif
    </div>
</div>
@endsection
