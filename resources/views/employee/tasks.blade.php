@extends('employee.layout')
@section('title', 'مهامي')
@section('content')

<div class="welcome">
    <h2><i class="bi bi-check2-square"></i> مهامي</h2>
    <p>قائمة المهام المكلّف بها</p>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(!$employee)
    <div class="card"><div class="alert alert-warning mb-0">حسابك غير مربوط بملف موظف.</div></div>
@elseif($tasks->isEmpty())
    <div class="card" style="text-align:center;padding:40px;color:#9ca3af">
        <i class="bi bi-check2-square" style="font-size:40px"></i>
        <p class="mt-3">لا توجد مهام مكلّف بها حالياً</p>
    </div>
@else
    @php
        $pColors = ['low'=>'#6b7280','medium'=>'#d97706','high'=>'#dc2626','urgent'=>'#7c3aed'];
        $pBgs    = ['low'=>'#f3f4f6','medium'=>'#fef3c7','high'=>'#fee2e2','urgent'=>'#ede9fe'];
        $sColors = ['new'=>'#6b7280','in_progress'=>'#d97706','completed'=>'#16a34a','cancelled'=>'#dc2626'];
        $sBgs    = ['new'=>'#f3f4f6','in_progress'=>'#fef3c7','completed'=>'#dcfce7','cancelled'=>'#fee2e2'];
    @endphp

    {{-- ملخص --}}
    <div class="row g-3 mb-4">
        @foreach(['new'=>['جديدة','#6b7280','bi-circle'],'in_progress'=>['قيد التنفيذ','#d97706','bi-hourglass-split'],'completed'=>['مكتملة','#16a34a','bi-check-circle']] as $s=>[$l,$c,$i])
        <div class="col-4">
            <div style="background:white;border-radius:12px;padding:15px;text-align:center;box-shadow:0 1px 4px rgba(0,0,0,0.06)">
                <i class="bi {{ $i }}" style="font-size:22px;color:{{ $c }}"></i>
                <div style="font-size:22px;font-weight:800;color:#1a1a2e;margin:4px 0">{{ $tasks->where('status',$s)->count() }}</div>
                <div style="font-size:12px;color:#6b7280">{{ $l }}</div>
            </div>
        </div>
        @endforeach
    </div>

    @foreach($tasks->sortBy(fn($t) => $t->status === 'completed' ? 1 : 0) as $task)
    <div class="card" style="margin-bottom:15px;opacity:{{ $task->status === 'completed' ? '0.7' : '1' }}">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;flex-wrap:wrap;gap:8px">
            <div>
                <div style="font-weight:700;font-size:15px {{ $task->status === 'completed' ? ';text-decoration:line-through' : '' }}">{{ $task->title }}</div>
                @if($task->due_date)
                <div style="font-size:12px;color:{{ $task->isOverdue() ? '#dc2626' : '#9ca3af' }};margin-top:3px">
                    <i class="bi bi-calendar{{ $task->isOverdue() ? '-x' : '' }}"></i>
                    {{ $task->due_date->format('Y-m-d') }}
                    @if($task->isOverdue()) <strong>(متأخرة)</strong> @endif
                </div>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span style="background:{{ $pBgs[$task->priority]??'#f3f4f6' }};color:{{ $pColors[$task->priority]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:11px">{{ $task->priority_label }}</span>
                <span style="background:{{ $sBgs[$task->status]??'#f3f4f6' }};color:{{ $sColors[$task->status]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:11px">{{ $task->status_label }}</span>
            </div>
        </div>

        @if($task->description)
        <div style="color:#6b7280;font-size:13px;margin-bottom:10px">{{ $task->description }}</div>
        @endif

        @if($task->status !== 'completed' && $task->status !== 'cancelled')
        <form action="{{ route('portal.tasks.status', $task->id) }}" method="POST">
            @csrf
            <div class="d-flex gap-2 align-items-center">
                <select name="status" class="form-select" style="font-size:13px;padding:5px 10px;width:auto">
                    @foreach(['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة'] as $v=>$l)
                        <option value="{{ $v }}" {{ $task->status==$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-action" style="font-size:13px;padding:6px 14px">تحديث</button>
            </div>
        </form>
        @endif
    </div>
    @endforeach
@endif
@endsection
