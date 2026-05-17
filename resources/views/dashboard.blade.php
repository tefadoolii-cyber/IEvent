@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')

<div class="top-header">
    <h4>لوحة التحكم</h4>
    <span style="color:#9ca3af; font-size:14px">{{ now()->translatedFormat('l، d F Y') }}</span>
</div>

{{-- إحصائيات عامة --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#4ade80; margin-bottom:8px"><i class="bi bi-people-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e">{{ $totalEmployees }}</div>
            <div style="color:#6b7280; font-size:13px">إجمالي الموظفين</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#3b82f6; margin-bottom:8px"><i class="bi bi-check-circle-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e">{{ $todayPresent }}</div>
            <div style="color:#6b7280; font-size:13px">حاضرون اليوم</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#f59e0b; margin-bottom:8px"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e">{{ $activeContracts }}</div>
            <div style="color:#6b7280; font-size:13px">عقود سارية</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#ef4444; margin-bottom:8px"><i class="bi bi-x-circle-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e">{{ $todayAbsent }}</div>
            <div style="color:#6b7280; font-size:13px">غائبون اليوم</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#7c3aed; margin-bottom:8px"><i class="bi bi-headset"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e">{{ $openTickets }}</div>
            <div style="color:#6b7280; font-size:13px">تذاكر مفتوحة</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- آخر الموظفين --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-person-plus"></i> آخر الموظفين المضافين</span>
                <a href="{{ route('employees.index') }}" style="font-size:13px; color:#9ca3af">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>القسم</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestEmployees as $emp)
                        <tr>
                            <td>
                                <div style="font-weight:600; font-size:14px">{{ $emp->name }}</div>
                                <div style="color:#9ca3af; font-size:12px">{{ $emp->employee_number }}</div>
                            </td>
                            <td style="font-size:13px">{{ $emp->department ?? '-' }}</td>
                            <td>
                                @if($emp->status == 'active')
                                    <span class="badge-active">نشط</span>
                                @else
                                    <span class="badge-inactive">غير نشط</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-3" style="color:#9ca3af">لا يوجد موظفين</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- حضور اليوم --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-calendar-check"></i> سجل حضور اليوم</span>
                <a href="{{ route('attendance.index') }}" style="font-size:13px; color:#9ca3af">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>وقت الحضور</th>
                            <th>وقت الانصراف</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayAttendance as $att)
                        <tr>
                            <td style="font-size:14px; font-weight:600">{{ $att->employee->name ?? '-' }}</td>
                            <td style="font-size:13px">{{ $att->check_in ?? '-' }}</td>
                            <td style="font-size:13px">{{ $att->check_out ?? '-' }}</td>
                            <td>
                                @if($att->status == 'present')
                                    <span class="badge-present">حاضر</span>
                                @elseif($att->status == 'absent')
                                    <span class="badge-absent">غائب</span>
                                @else
                                    <span class="badge-late">متأخر</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-3" style="color:#9ca3af">لا توجد سجلات اليوم</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- آخر العقود --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-file-earmark-text"></i> آخر العقود</span>
                <a href="{{ route('contracts.index') }}" style="font-size:13px; color:#9ca3af">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>رقم العقد</th>
                            <th>الموظف</th>
                            <th>المسمى</th>
                            <th>الراتب</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestContracts as $contract)
                        @php
                            $colors = ['draft' => '#6b7280', 'sent' => '#d97706', 'signed' => '#16a34a', 'cancelled' => '#dc2626'];
                            $bgs    = ['draft' => '#f3f4f6', 'sent' => '#fef3c7', 'signed' => '#dcfce7', 'cancelled' => '#fee2e2'];
                        @endphp
                        <tr>
                            <td style="font-family:monospace;font-size:12px">{{ $contract->contract_number }}</td>
                            <td style="font-weight:600">{{ $contract->employee->name }}</td>
                            <td style="font-size:13px">{{ $contract->position ?? '-' }}</td>
                            <td style="font-size:13px">{{ $contract->salary ? number_format($contract->salary, 0) . ' ر.س' : '-' }}</td>
                            <td>
                                <span style="background:{{ $bgs[$contract->status] ?? '#f3f4f6' }};color:{{ $colors[$contract->status] ?? '#6b7280' }};padding:3px 10px;border-radius:20px;font-size:12px">
                                    {{ $contract->status_label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-3" style="color:#9ca3af">لا توجد عقود بعد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Chart.js: الحضور الشهري --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-bar-chart-line"></i> الحضور الشهري (آخر 6 أشهر)</span></div>
            <div class="card-body" style="padding:20px">
                <canvas id="attendanceChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart.js: الموظفون حسب القسم --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-pie-chart"></i> الموظفون حسب القسم</span></div>
            <div class="card-body" style="padding:20px">
                <canvas id="deptChart" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
// الحضور الشهري
new Chart(document.getElementById('attendanceChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($attendanceChart->pluck('month')) !!},
        datasets: [
            {
                label: 'حضور',
                data: {!! json_encode($attendanceChart->pluck('present')) !!},
                backgroundColor: 'rgba(22,163,74,0.7)',
                borderColor: '#16a34a',
                borderWidth: 1,
            },
            {
                label: 'غياب',
                data: {!! json_encode($attendanceChart->pluck('absent')) !!},
                backgroundColor: 'rgba(220,38,38,0.7)',
                borderColor: '#dc2626',
                borderWidth: 1,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});

// القسم
@if($deptChart->count())
new Chart(document.getElementById('deptChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($deptChart->keys()) !!},
        datasets: [{
            data: {!! json_encode($deptChart->values()) !!},
            backgroundColor: ['#3b82f6','#16a34a','#d97706','#dc2626','#7c3aed','#0891b2','#db2777'],
            borderWidth: 2,
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } } }
});
@else
document.getElementById('deptChart').parentElement.innerHTML = '<p style="text-align:center;color:#9ca3af;font-size:13px;padding:40px 0">لا توجد بيانات</p>';
@endif
</script>

@endsection
