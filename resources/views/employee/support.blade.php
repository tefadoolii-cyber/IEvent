@extends('employee.layout')
@section('title', 'الدعم الفني')
@section('content')

<div class="welcome">
    <h2><i class="bi bi-headset"></i> الدعم الفني</h2>
    <p>أرسل طلب دعم وتابع تذاكرك</p>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- نموذج تذكرة جديدة --}}
<div class="card" style="margin-bottom:20px">
    <h5 style="font-weight:700;margin-bottom:20px"><i class="bi bi-plus-circle"></i> طلب دعم جديد</h5>
    <form action="{{ route('portal.support.store') }}" method="POST">
        @csrf
        @if($errors->any())
            <div style="background:#fee2e2;color:#dc2626;padding:10px;border-radius:8px;margin-bottom:15px;font-size:13px">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label" style="font-size:13px">عنوان الطلب *</label>
                <input type="text" name="title" class="form-control" style="font-size:14px" value="{{ old('title') }}" required placeholder="وصف مختصر للمشكلة">
            </div>
            <div class="col-md-4">
                <label class="form-label" style="font-size:13px">الأولوية *</label>
                <select name="priority" class="form-select" style="font-size:14px">
                    @foreach(['low'=>'منخفضة','medium'=>'متوسطة','high'=>'عالية','urgent'=>'عاجلة'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('priority','medium')==$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label" style="font-size:13px">وصف تفصيلي *</label>
                <textarea name="description" class="form-control" style="font-size:14px" rows="4" required placeholder="اشرح المشكلة بالتفصيل...">{{ old('description') }}</textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn-action" style="font-size:14px;padding:10px 24px">
                    <i class="bi bi-send"></i> إرسال الطلب
                </button>
            </div>
        </div>
    </form>
</div>

{{-- قائمة التذاكر --}}
<div>
    <h5 style="font-weight:700;margin-bottom:15px">تذاكري السابقة</h5>
    @if($tickets->isEmpty())
    <div class="card" style="text-align:center;padding:30px;color:#9ca3af">
        <i class="bi bi-inbox" style="font-size:30px"></i>
        <p class="mt-2">لا توجد تذاكر سابقة</p>
    </div>
    @else
    @php
        $pColors = ['low'=>'#6b7280','medium'=>'#d97706','high'=>'#dc2626','urgent'=>'#7c3aed'];
        $pBgs    = ['low'=>'#f3f4f6','medium'=>'#fef3c7','high'=>'#fee2e2','urgent'=>'#ede9fe'];
        $sColors = ['open'=>'#dc2626','in_progress'=>'#d97706','resolved'=>'#16a34a','closed'=>'#6b7280'];
        $sBgs    = ['open'=>'#fee2e2','in_progress'=>'#fef3c7','resolved'=>'#dcfce7','closed'=>'#f3f4f6'];
    @endphp
    @foreach($tickets as $ticket)
    <div class="card" style="margin-bottom:12px">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:8px">
            <div>
                <div style="font-weight:700;font-size:14px">{{ $ticket->title }}</div>
                <div style="color:#9ca3af;font-size:12px;margin-top:3px">{{ $ticket->created_at->format('Y-m-d H:i') }}</div>
            </div>
            <div class="d-flex gap-2">
                <span style="background:{{ $pBgs[$ticket->priority]??'#f3f4f6' }};color:{{ $pColors[$ticket->priority]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:11px">{{ $ticket->priority_label }}</span>
                <span style="background:{{ $sBgs[$ticket->status]??'#f3f4f6' }};color:{{ $sColors[$ticket->status]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:11px">{{ $ticket->status_label }}</span>
            </div>
        </div>
        @if($ticket->resolution_notes)
        <div style="background:#f0fdf4;border-radius:8px;padding:10px;margin-top:10px;font-size:13px;color:#374151">
            <strong style="color:#16a34a"><i class="bi bi-check-circle"></i> رد الإدارة:</strong>
            <div style="margin-top:4px;white-space:pre-line">{{ $ticket->resolution_notes }}</div>
        </div>
        @endif
    </div>
    @endforeach
    @endif
</div>
@endsection
