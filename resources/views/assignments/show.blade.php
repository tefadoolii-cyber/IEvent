@extends('layouts.app')
@section('title', 'تفاصيل الإسناد')
@section('content')

<div class="top-header">
    <h4>تفاصيل الإسناد</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('assignments.edit', $assignment->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('assignments.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@php
    $sColors = ['active'=>'#16a34a','completed'=>'#6b7280','cancelled'=>'#dc2626'];
    $sBgs    = ['active'=>'#dcfce7','completed'=>'#f3f4f6','cancelled'=>'#fee2e2'];
@endphp

<div class="row g-3">

    {{-- الموظف --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header" style="font-weight:600"><i class="bi bi-person-badge me-1"></i>بيانات الموظف</div>
            <div class="card-body" style="padding:20px">
                @if($assignment->employee)
                <div class="row g-2">
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">الاسم</div>
                        <div style="font-weight:600">{{ $assignment->employee->name }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">الرقم الوظيفي</div>
                        <div style="font-weight:600">{{ $assignment->employee->employee_number ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">القسم</div>
                        <div>{{ $assignment->employee->department ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">المسمى الوظيفي</div>
                        <div>{{ $assignment->employee->position ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">الجوال</div>
                        <div>{{ $assignment->employee->phone ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">الحالة</div>
                        <div>{{ $assignment->employee->status ?? '-' }}</div>
                    </div>
                </div>
                @else
                <span style="color:#9ca3af">لم يحدد موظف</span>
                @endif
            </div>
        </div>
    </div>

    {{-- الموقع --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header" style="font-weight:600"><i class="bi bi-geo-alt me-1"></i>الموقع</div>
            <div class="card-body" style="padding:20px">
                @if($assignment->location)
                <div class="row g-2">
                    <div class="col-12">
                        <div style="color:#6b7280;font-size:11px">اسم الموقع</div>
                        <div style="font-weight:600;font-size:15px">{{ $assignment->location->name }}</div>
                    </div>
                    @if($assignment->location->region)
                    <div class="col-12">
                        <div style="color:#6b7280;font-size:11px">المنطقة</div>
                        <div>
                            @if($assignment->location->region->parent)
                                <span style="color:#9ca3af">{{ $assignment->location->region->parent->name }} ← </span>
                            @endif
                            <span style="background:#eff6ff;color:#1d4ed8;padding:2px 10px;border-radius:20px;font-size:13px">{{ $assignment->location->region->name }}</span>
                        </div>
                    </div>
                    @endif
                    @if($assignment->location->city)
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">المدينة</div>
                        <div>{{ $assignment->location->city }}</div>
                    </div>
                    @endif
                    @if($assignment->location->address)
                    <div class="col-12">
                        <div style="color:#6b7280;font-size:11px">العنوان</div>
                        <div style="font-size:13px">{{ $assignment->location->address }}</div>
                    </div>
                    @endif
                    @if($assignment->location->lat && $assignment->location->lng)
                    <div class="col-12 mt-1">
                        <a href="https://www.google.com/maps?q={{ $assignment->location->lat }},{{ $assignment->location->lng }}"
                           target="_blank"
                           class="btn btn-sm"
                           style="background:#1d4ed8;color:white;border-radius:8px;font-size:13px;padding:6px 14px">
                            <i class="bi bi-pin-map-fill me-1"></i>فتح في Google Maps
                        </a>
                    </div>
                    @endif
                </div>
                @else
                <span style="color:#9ca3af">لم يحدد موقع</span>
                @endif
            </div>
        </div>
    </div>

    {{-- تفاصيل الإسناد --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header" style="font-weight:600"><i class="bi bi-clipboard-check me-1"></i>تفاصيل الإسناد</div>
            <div class="card-body" style="padding:20px">
                <div class="row g-2">
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">الحالة</div>
                        <div>
                            <span style="background:{{ $sBgs[$assignment->status]??'#f3f4f6' }};color:{{ $sColors[$assignment->status]??'#6b7280' }};padding:3px 12px;border-radius:20px;font-size:13px">
                                {{ $assignment->status_label }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">الدور / المهمة</div>
                        <div style="font-weight:600">{{ $assignment->role ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">تاريخ البداية</div>
                        <div>{{ $assignment->start_date?->format('Y-m-d') ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">تاريخ النهاية</div>
                        <div>{{ $assignment->end_date?->format('Y-m-d') ?? 'مفتوح' }}</div>
                    </div>
                    @if($assignment->company)
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">الشركة</div>
                        <div>{{ $assignment->company->name }}</div>
                    </div>
                    @endif
                    @if($assignment->supervisor)
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">المشرف</div>
                        <div>{{ $assignment->supervisor->name }}</div>
                    </div>
                    @endif
                    @if($assignment->notes)
                    <div class="col-12">
                        <div style="color:#6b7280;font-size:11px">ملاحظات</div>
                        <div style="background:#f9fafb;border-radius:8px;padding:10px;font-size:13px;margin-top:4px">{{ $assignment->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- معلومات إضافية --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header" style="font-weight:600"><i class="bi bi-info-circle me-1"></i>معلومات إضافية</div>
            <div class="card-body" style="padding:20px">
                <div class="row g-2">
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">رقم الإسناد</div>
                        <div style="font-weight:600">#{{ $assignment->id }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">تاريخ الإنشاء</div>
                        <div>{{ $assignment->created_at?->format('Y-m-d') }}</div>
                    </div>
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">آخر تعديل</div>
                        <div>{{ $assignment->updated_at?->format('Y-m-d') }}</div>
                    </div>
                    @if($assignment->start_date && $assignment->end_date)
                    <div class="col-6">
                        <div style="color:#6b7280;font-size:11px">مدة الإسناد</div>
                        <div>{{ $assignment->start_date->diffInDays($assignment->end_date) }} يوم</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<div class="d-flex gap-2 mt-3">
    <a href="{{ route('assignments.edit', $assignment->id) }}" class="btn btn-save"><i class="bi bi-pencil"></i> تعديل</a>
    <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" onsubmit="return confirm('حذف هذا الإسناد؟')">
        @csrf @method('DELETE')
        <button class="btn btn-delete"><i class="bi bi-trash"></i> حذف</button>
    </form>
    <a href="{{ route('assignments.index') }}" class="btn btn-back">رجوع للقائمة</a>
</div>

@endsection
