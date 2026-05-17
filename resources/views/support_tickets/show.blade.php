@extends('layouts.app')
@section('title', 'تفاصيل التذكرة')
@section('content')

<div class="top-header">
    <h4>تذكرة #{{ $supportTicket->id }} - {{ Str::limit($supportTicket->title, 40) }}</h4>
    <a href="{{ route('support-tickets.index') }}" class="btn btn-back">رجوع</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><span style="font-weight:600">تفاصيل الطلب</span></div>
            <div class="card-body" style="padding:20px">
                <h5 style="font-weight:700;margin-bottom:12px">{{ $supportTicket->title }}</h5>
                <div style="background:#f9fafb;padding:15px;border-radius:8px;font-size:14px;line-height:1.8;white-space:pre-line;margin-bottom:15px">{{ $supportTicket->description }}</div>
                @if($supportTicket->resolution_notes)
                <hr>
                <div style="color:#16a34a;font-weight:600;margin-bottom:8px"><i class="bi bi-check-circle"></i> ملاحظات الحل:</div>
                <div style="background:#f0fdf4;padding:15px;border-radius:8px;font-size:14px;line-height:1.8;white-space:pre-line">{{ $supportTicket->resolution_notes }}</div>
                @endif
            </div>
        </div>

        {{-- تحديث الحالة --}}
        <div class="card">
            <div class="card-header"><span style="font-weight:600">تحديث الحالة</span></div>
            <div class="card-body" style="padding:20px">
                <form action="{{ route('support-tickets.update', $supportTicket->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                @foreach(['open'=>'مفتوحة','in_progress'=>'قيد المعالجة','resolved'=>'محلولة','closed'=>'مغلقة'] as $v=>$l)
                                    <option value="{{ $v }}" {{ $supportTicket->status==$v?'selected':'' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">ملاحظات الحل</label>
                            <textarea name="resolution_notes" class="form-control" rows="4">{{ $supportTicket->resolution_notes }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600">معلومات</span></div>
            <div class="card-body" style="padding:20px">
                @php
                    $pColors = ['low'=>'#6b7280','medium'=>'#d97706','high'=>'#dc2626','urgent'=>'#7c3aed'];
                    $pBgs    = ['low'=>'#f3f4f6','medium'=>'#fef3c7','high'=>'#fee2e2','urgent'=>'#ede9fe'];
                    $sColors = ['open'=>'#dc2626','in_progress'=>'#d97706','resolved'=>'#16a34a','closed'=>'#6b7280'];
                    $sBgs    = ['open'=>'#fee2e2','in_progress'=>'#fef3c7','resolved'=>'#dcfce7','closed'=>'#f3f4f6'];
                @endphp
                @foreach(['المستخدم'=>$supportTicket->user->name??'-','تاريخ الإنشاء'=>$supportTicket->created_at->format('Y-m-d H:i')] as $l=>$v)
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <span style="color:#6b7280">{{ $l }}</span><span style="font-weight:600">{{ $v }}</span>
                </div>
                @endforeach
                <div style="padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px;display:flex;justify-content:space-between">
                    <span style="color:#6b7280">الأولوية</span>
                    <span style="background:{{ $pBgs[$supportTicket->priority]??'#f3f4f6' }};color:{{ $pColors[$supportTicket->priority]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:11px">{{ $supportTicket->priority_label }}</span>
                </div>
                <div style="padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px;display:flex;justify-content:space-between">
                    <span style="color:#6b7280">الحالة</span>
                    <span style="background:{{ $sBgs[$supportTicket->status]??'#f3f4f6' }};color:{{ $sColors[$supportTicket->status]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:11px">{{ $supportTicket->status_label }}</span>
                </div>
                @if($supportTicket->resolved_at)
                <div style="padding:8px 0;font-size:13px;display:flex;justify-content:space-between">
                    <span style="color:#6b7280">تاريخ الحل</span>
                    <span style="font-weight:600">{{ $supportTicket->resolved_at->format('Y-m-d H:i') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
