@extends('layouts.app')
@section('title', 'تفاصيل طلب التوظيف')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-person-lines-fill"></i> طلب توظيف — {{ $application->full_name }}</h4>
    <div class="d-flex gap-2">
        @if($application->status === 'accepted')
        <a href="{{ route('job-applications.convert', $application->id) }}" class="btn btn-save" style="background:#16a34a">
            <i class="bi bi-person-plus"></i> تحويل لموظف
        </a>
        @endif
        <a href="{{ route('job-applications.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">
    {{-- بطاقة المتقدم --}}
    <div class="col-md-4">
        <div class="card mb-3" style="text-align:center;padding:28px">
            <div style="width:90px;height:90px;border-radius:50%;overflow:hidden;margin:0 auto 14px;border:3px solid #e5e7eb;background:#1a1a2e;display:flex;align-items:center;justify-content:center">
                @if($application->photo)
                    <img src="{{ Storage::disk('public')->url($application->photo) }}" style="width:90px;height:90px;object-fit:cover">
                @else
                    <span style="color:white;font-weight:700;font-size:36px">{{ mb_substr($application->full_name,0,1) }}</span>
                @endif
            </div>
            <div style="font-weight:800;font-size:18px;color:#1a1a2e">{{ $application->full_name }}</div>
            <div style="font-family:monospace;font-size:12px;color:#9ca3af;margin-top:4px">{{ $application->id_number }}</div>
            <div style="margin-top:10px">
                <span style="background:{{ $application->status_bg }};color:{{ $application->status_color }};padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600">
                    {{ $application->status_label }}
                </span>
            </div>
            @if($application->cv_file)
            <div style="margin-top:16px">
                <a href="{{ Storage::disk('public')->url($application->cv_file) }}" target="_blank"
                   style="display:inline-flex;align-items:center;gap:6px;background:#dbeafe;color:#2563eb;padding:8px 16px;border-radius:8px;font-size:13px;text-decoration:none;font-weight:600">
                    <i class="bi bi-download"></i> تحميل السيرة الذاتية
                </a>
            </div>
            @endif
            <div style="margin-top:8px;font-size:11px;color:#9ca3af">
                تاريخ التقديم: {{ $application->created_at->format('Y-m-d H:i') }}
            </div>
        </div>

        {{-- مراجعة الطلب --}}
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-check-circle"></i> مراجعة الطلب</span></div>
            <div class="card-body" style="padding:20px">
                <form action="{{ route('job-applications.review', $application->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom:14px">
                        <label style="font-size:13px;font-weight:600;margin-bottom:6px;display:block">القرار</label>
                        <select name="status" class="form-select" style="font-size:13px">
                            <option value="pending"  {{ $application->status == 'pending'  ? 'selected' : '' }}>معلق</option>
                            <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>تمت المراجعة</option>
                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>مقبول</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                    <div style="margin-bottom:14px">
                        <label style="font-size:13px;font-weight:600;margin-bottom:6px;display:block">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3" style="font-size:13px" placeholder="أسباب القبول أو الرفض...">{{ $application->notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-save w-100" style="font-size:13px">
                        <i class="bi bi-check"></i> حفظ القرار
                    </button>
                </form>
                @if($application->reviewer)
                <div style="margin-top:12px;padding:10px;background:#f9fafb;border-radius:8px;font-size:12px;color:#6b7280">
                    <i class="bi bi-person-check"></i> راجعه: {{ $application->reviewer->name }}
                    {{ $application->reviewed_at ? 'في ' . $application->reviewed_at->format('Y-m-d') : '' }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- بيانات الطلب --}}
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-person-badge"></i> البيانات الشخصية</span></div>
            <div class="card-body" style="padding:20px">
                @php
                    $expLabels = ['0'=>'بدون خبرة', '1'=>'أقل من سنة', '2'=>'1-2 سنة', '3'=>'3-5 سنوات', '4'=>'6-10 سنوات', '5'=>'أكثر من 10 سنوات'];
                @endphp
                @foreach([
                    ['icon' => 'bi-phone',      'label' => 'رقم الجوال',        'value' => $application->phone],
                    ['icon' => 'bi-envelope',   'label' => 'البريد الإلكتروني', 'value' => $application->email],
                    ['icon' => 'bi-calendar',   'label' => 'تاريخ الميلاد',     'value' => $application->date_of_birth?->format('Y-m-d')],
                    ['icon' => 'bi-flag',       'label' => 'الجنسية',           'value' => $application->nationality],
                    ['icon' => 'bi-geo-alt',    'label' => 'العنوان',           'value' => $application->address],
                    ['icon' => 'bi-mortarboard','label' => 'المؤهل العلمي',     'value' => $application->education_level],
                    ['icon' => 'bi-briefcase',  'label' => 'سنوات الخبرة',      'value' => $expLabels[$application->experience_years] ?? $application->experience_years],
                    ['icon' => 'bi-person-workspace', 'label' => 'الوظيفة المطلوبة', 'value' => $application->desired_position],
                    ['icon' => 'bi-cash',       'label' => 'الراتب المتوقع',    'value' => $application->expected_salary ? number_format($application->expected_salary, 0) . ' ر.س' : null],
                ] as $item)
                <div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi {{ $item['icon'] }}" style="color:#9ca3af;width:18px;flex-shrink:0"></i>
                    <span style="color:#6b7280;flex:1">{{ $item['label'] }}</span>
                    <span style="font-weight:600">{{ $item['value'] ?? '-' }}</span>
                </div>
                @endforeach
            </div>
        </div>

        @if($application->cover_letter)
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-chat-text"></i> خطاب التقديم</span></div>
            <div class="card-body" style="padding:20px;font-size:14px;line-height:1.8;color:#374151;white-space:pre-line">{{ $application->cover_letter }}</div>
        </div>
        @endif
    </div>
</div>

@endsection
