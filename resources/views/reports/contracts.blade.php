@extends('layouts.app')
@section('title', 'تقرير العقود')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-file-earmark-text"></i> تقرير العقود</h4>
    <a href="{{ route('reports.index') }}" class="btn btn-back">رجوع</a>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                @foreach(['draft'=>'مسودة','sent'=>'مُرسل','signed'=>'موقّع','cancelled'=>'ملغي'] as $val=>$lbl)
                <option value="{{ $val }}" {{ $status==$val?'selected':'' }}>{{ $lbl }}</option>
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

@if($statusCounts->count())
<div class="card mb-4">
    <div class="card-header"><span style="font-weight:600">توزيع العقود حسب الحالة</span></div>
    <div class="card-body" style="padding:20px">
        <canvas id="contractChart" height="80"></canvas>
    </div>
</div>
@endif

<div class="card">
    <div class="card-body p-0">
        @if($contracts->count())
        @php
            $statusLabels = ['draft'=>'مسودة','sent'=>'مُرسل','signed'=>'موقّع','cancelled'=>'ملغي'];
            $sc = ['draft'=>'#6b7280','sent'=>'#3b82f6','signed'=>'#16a34a','cancelled'=>'#dc2626'];
            $sb = ['draft'=>'#f3f4f6','sent'=>'#eff6ff','signed'=>'#dcfce7','cancelled'=>'#fee2e2'];
        @endphp
        <table class="table mb-0">
            <thead>
                <tr><th>الموظف</th><th>نوع العقد</th><th>البداية</th><th>الانتهاء</th><th>الراتب</th><th>الحالة</th></tr>
            </thead>
            <tbody>
                @foreach($contracts as $c)
                <tr>
                    <td style="font-weight:600;font-size:13px">{{ $c->employee?->name ?? '—' }}</td>
                    <td style="font-size:13px">{{ $c->type ?? '—' }}</td>
                    <td style="font-size:12px;color:#9ca3af">{{ $c->start_date ?? '—' }}</td>
                    <td style="font-size:12px;color:#9ca3af">{{ $c->end_date ?? '—' }}</td>
                    <td style="font-size:13px">{{ $c->salary ? number_format($c->salary, 0).' ر.س' : '—' }}</td>
                    <td>
                        <span style="background:{{ $sb[$c->status]??'#f3f4f6' }};color:{{ $sc[$c->status]??'#6b7280' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $statusLabels[$c->status] ?? $c->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-file-earmark" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد عقود</p>
        </div>
        @endif
    </div>
</div>

@if($statusCounts->count())
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('contractChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($statusCounts->keys()->map(fn($k)=>['draft'=>'مسودة','sent'=>'مُرسل','signed'=>'موقّع','cancelled'=>'ملغي'][$k]??$k)->values()) !!},
        datasets: [{
            label: 'عدد العقود',
            data: {!! json_encode($statusCounts->values()) !!},
            backgroundColor: ['#f3f4f6','#eff6ff','#dcfce7','#fee2e2'],
            borderColor: ['#6b7280','#3b82f6','#16a34a','#dc2626'],
            borderWidth: 2,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
</script>
@endif
@endsection
