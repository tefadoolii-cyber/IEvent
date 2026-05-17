@extends('layouts.app')
@section('title', 'تحويل إلى موظف')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-person-plus"></i> تحويل المتقدم إلى موظف</h4>
    <a href="{{ route('job-applications.show', $application->id) }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach
</div>
@endif

{{-- بطاقة المتقدم --}}
<div class="card mb-3" style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe);border:1px solid #bae6fd">
    <div class="card-body" style="padding:16px 20px">
        <div style="display:flex;align-items:center;gap:14px">
            <div style="width:56px;height:56px;border-radius:50%;overflow:hidden;background:#1a1a2e;flex-shrink:0;display:flex;align-items:center;justify-content:center;border:2px solid white">
                @if($application->photo)
                    <img src="{{ Storage::disk('public')->url($application->photo) }}" style="width:56px;height:56px;object-fit:cover">
                @else
                    <span style="color:white;font-weight:700;font-size:22px">{{ mb_substr($application->full_name,0,1) }}</span>
                @endif
            </div>
            <div>
                <div style="font-weight:700;font-size:16px;color:#1a1a2e">{{ $application->full_name }}</div>
                <div style="font-size:12px;color:#0369a1">{{ $application->desired_position }} | {{ $application->phone }}</div>
            </div>
            <div style="margin-right:auto;font-size:12px;color:#0369a1">
                <i class="bi bi-info-circle"></i> سيتم نسخ الصورة والسيرة الذاتية تلقائياً
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('job-applications.do-convert', $application->id) }}" method="POST">
            @csrf

            <div class="section-title">البيانات الأساسية (مملوءة من الطلب)</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الاسم الكامل *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $application->full_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">رقم الهوية (يُستخدم كرقم موظف) *</label>
                    <input type="text" name="employee_number" class="form-control" value="{{ old('employee_number', $application->id_number) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">رقم الجوال</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $application->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $application->email) }}">
                </div>
            </div>

            <div class="section-title">بيانات التعيين</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">القسم</label>
                    <select name="department" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->value_ar }}" {{ old('department') == $dept->value_ar ? 'selected' : '' }}>{{ $dept->value_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المسمى الوظيفي</label>
                    <select name="position" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($jobTitles as $job)
                            <option value="{{ $job->value_ar }}"
                                {{ old('position', $application->desired_position) == $job->value_ar ? 'selected' : '' }}>
                                {{ $job->value_ar }}
                            </option>
                        @endforeach
                    </select>
                    <div style="font-size:11px;color:#9ca3af;margin-top:4px">الوظيفة المطلوبة: {{ $application->desired_position }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">تاريخ المباشرة</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', date('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">تاريخ نهاية العقد</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">حالة الموظف</label>
                    <select name="status" class="form-select">
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-person-plus-fill"></i> تحويل وإنشاء ملف الموظف
                </button>
                <a href="{{ route('job-applications.show', $application->id) }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@endsection
