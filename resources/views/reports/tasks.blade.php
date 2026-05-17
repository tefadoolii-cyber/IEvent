@extends('layouts.app')
@section('title', 'تقرير المهام')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-check2-square"></i> تقرير المهام</h4>
    <a href="{{ route('reports.index') }}" class="btn btn-back">رجوع</a>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                @foreach(['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة'] as $val=>$lbl)
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
<div class="row g-3 mb-4">
    @foreach(['new'=>['لون'=>'#6b7280','اسم'=>'جديدة'],'in_progress'=>['لون'=>'#3b82f6','اسم'=>'قيد التنفيذ'],'completed'=>['لون'=>'#16a34a','اسم'=>'مكتملة']] as $st=>$info)
    <div class="col-md-4">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid {{ $info['لون'] }}">
            <div style="font-size:26px;font-weight:800;color:{{ $info['لون'] }}">{{ $statusCounts->get($st, 0) }}</div>
            <div style="font-size:12px;color:#9ca3af">{{ $info['اسم'] }}</div>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="card">
    <div class="card-body p-0">
        @if($tasks->count())
        @php
            $sc = ['new'=>'#6b7280','in_progress'=>'#3b82f6','completed'=>'#16a34a'];
            $sb = ['new'=>'#f3f4f6','in_progress'=>'#eff6ff','completed'=>'#dcfce7'];
            $sl = ['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة'];
        @endphp
        <table class="table mb-0">
            <thead>
                <tr><th>المهمة</th><th>الموظف</th><th>الأولوية</th><th>الاستحقاق</th><th>الحالة</th></tr>
            </thead>
            <tbody>
                @foreach($tasks as $t)
                <tr>
                    <td style="font-weight:600;font-size:13px">{{ $t->title }}</td>
                    <td style="font-size:13px">{{ $t->employee?->name ?? '—' }}</td>
                    <td style="font-size:12px">{{ $t->priority ?? '—' }}</td>
                    <td style="font-size:12px;color:{{ $t->due_date && $t->due_date < today() && $t->status!='completed' ? '#dc2626' : '#9ca3af' }}">
                        {{ $t->due_date ?? '—' }}
                    </td>
                    <td>
                        <span style="background:{{ $sb[$t->status]??'#f3f4f6' }};color:{{ $sc[$t->status]??'#6b7280' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $sl[$t->status] ?? $t->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-check2-square" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد مهام</p>
        </div>
        @endif
    </div>
</div>
@endsection
