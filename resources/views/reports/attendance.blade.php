@extends('layouts.app')
@section('title', 'تقرير الحضور')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-calendar-check"></i> تقرير الحضور الشهري</h4>
    <a href="{{ route('reports.index') }}" class="btn btn-back">رجوع</a>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <label class="form-label" style="font-size:13px">الشهر</label>
            <input type="month" name="month" class="form-control" value="{{ $month }}" style="font-size:13px">
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

<div class="row g-3 mb-4">
    @php
        $totalPresent = $summary->sum('present');
        $totalAbsent  = $summary->sum('absent');
        $totalLate    = $summary->sum('late');
    @endphp
    @foreach([
        ['val'=>$summary->count(), 'label'=>'الموظفون',  'color'=>'#374151'],
        ['val'=>$totalPresent,      'label'=>'حضور كلي',  'color'=>'#16a34a'],
        ['val'=>$totalAbsent,       'label'=>'غياب كلي',  'color'=>'#dc2626'],
        ['val'=>$totalLate,         'label'=>'تأخر كلي',  'color'=>'#d97706'],
    ] as $s)
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid {{ $s['color'] }}">
            <div style="font-size:26px;font-weight:800;color:{{ $s['color'] }}">{{ $s['val'] }}</div>
            <div style="font-size:12px;color:#9ca3af">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

@if($chartData->count())
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><span style="font-weight:600">توزيع الحضور</span></div>
            <div class="card-body" style="padding:20px;display:flex;align-items:center;justify-content:center">
                <div style="position:relative;width:100%;max-width:340px;max-height:280px">
                    <canvas id="attendanceChart" style="max-width:100%;max-height:280px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><span style="font-weight:600">الإحصائيات التفصيلية</span></div>
            <div class="card-body" style="padding:20px">
                @php
                    $grandTotal = $chartData->sum();
                @endphp
                @foreach(['present'=>['حضور','#16a34a','#dcfce7'],'absent'=>['غياب','#dc2626','#fee2e2'],'late'=>['تأخر','#d97706','#fef3c7']] as $key=>[$lbl,$color,$bg])
                @php $val = $chartData->get($key, 0); $pct = $grandTotal > 0 ? round($val/$grandTotal*100) : 0; @endphp
                <div style="margin-bottom:14px">
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:13px">
                        <span style="font-weight:600;color:{{ $color }}">{{ $lbl }}</span>
                        <span style="color:#6b7280">{{ $val }} ({{ $pct }}%)</span>
                    </div>
                    <div style="background:#f3f4f6;border-radius:10px;height:8px">
                        <div style="width:{{ $pct }}%;background:{{ $color }};border-radius:10px;height:8px;transition:width 0.5s"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-body p-0">
        @if($summary->count())
        <div class="table-responsive">
        <table class="table mb-0" style="min-width:600px">
            <thead>
                <tr><th>الموظف</th><th>رقم الموظف</th><th style="color:#16a34a">حضور</th><th style="color:#dc2626">غياب</th><th style="color:#d97706">تأخر</th><th>الإجمالي</th><th>النسبة</th></tr>
            </thead>
            <tbody>
                @foreach($summary as $row)
                @php $pct = $row['total'] > 0 ? round($row['present']/$row['total']*100) : 0; @endphp
                <tr>
                    <td style="font-weight:600;font-size:13px">{{ $row['employee']?->name ?? '—' }}</td>
                    <td style="font-size:12px;color:#9ca3af">{{ $row['employee']?->employee_number ?? '—' }}</td>
                    <td style="font-size:13px;color:#16a34a;font-weight:600">{{ $row['present'] }}</td>
                    <td style="font-size:13px;color:#dc2626;font-weight:600">{{ $row['absent'] }}</td>
                    <td style="font-size:13px;color:#d97706;font-weight:600">{{ $row['late'] }}</td>
                    <td style="font-size:13px">{{ $row['total'] }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div style="flex:1;background:#f3f4f6;border-radius:10px;height:6px">
                                <div style="width:{{ $pct }}%;background:#16a34a;border-radius:10px;height:6px"></div>
                            </div>
                            <span style="font-size:11px;color:#6b7280;min-width:30px">{{ $pct }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-calendar" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد بيانات لهذا الشهر</p>
        </div>
        @endif
    </div>
</div>

@if($chartData->count())
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('attendanceChart'), {
    type: 'doughnut',
    data: {
        labels: ['حضور','غياب','تأخر'],
        datasets: [{
            data: [
                {{ $chartData->get('present', 0) }},
                {{ $chartData->get('absent', 0) }},
                {{ $chartData->get('late', 0) }},
            ],
            backgroundColor: ['#16a34a','#dc2626','#d97706'],
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 12 }, padding: 12 } } }
    }
});
</script>
@endif
@endsection
