@extends('employee.layout')
@section('title', 'بياناتي')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="welcome">
    <h2><i class="bi bi-person-badge"></i> بياناتي الشخصية</h2>
    <p>عرض معلوماتك الوظيفية وتحديث صورتك وسيرتك الذاتية</p>
</div>

@if(!$employee)
    <div class="card">
        <div class="alert alert-warning mb-0">حسابك غير مربوط بملف موظف. راجع الإدارة.</div>
    </div>
@else

<div class="row g-3">
    {{-- بطاقة الموظف --}}
    <div class="col-md-4">
        <div class="card" style="text-align:center;padding:30px">
            {{-- الصورة --}}
            <div style="width:100px;height:100px;border-radius:50%;overflow:hidden;margin:0 auto 15px;border:3px solid #e5e7eb;background:#1a1a2e;display:flex;align-items:center;justify-content:center">
                @if($employee->photo)
                    <img src="{{ Storage::disk('public')->url($employee->photo) }}" id="profile-photo-preview" style="width:100px;height:100px;object-fit:cover">
                @else
                    <span id="profile-photo-preview" style="color:white;font-weight:700;font-size:40px">{{ mb_substr($employee->name,0,1) }}</span>
                @endif
            </div>
            <div style="font-weight:700;font-size:18px;color:#1a1a2e">{{ $employee->name }}</div>
            <div style="color:#9ca3af;font-size:13px;font-family:monospace;margin-top:4px">{{ $employee->employee_number }}</div>
            <div style="margin-top:8px">
                @if($employee->status === 'active')
                    <span style="background:#dcfce7;color:#16a34a;padding:4px 12px;border-radius:20px;font-size:12px">نشط</span>
                @else
                    <span style="background:#fee2e2;color:#dc2626;padding:4px 12px;border-radius:20px;font-size:12px">غير نشط</span>
                @endif
            </div>
            @if($employee->position || $employee->department)
            <div style="margin-top:10px;color:#6b7280;font-size:13px">
                {{ $employee->position }}{{ $employee->position && $employee->department ? ' — ' : '' }}{{ $employee->department }}
            </div>
            @endif
        </div>
    </div>

    {{-- البيانات الوظيفية --}}
    <div class="col-md-8">
        <div class="card" style="margin-bottom:20px">
            <h5 style="font-weight:700;margin-bottom:15px"><i class="bi bi-briefcase"></i> البيانات الوظيفية</h5>
            @foreach([
                'الاسم الكامل'    => $employee->name,
                'رقم الموظف'      => $employee->employee_number,
                'رقم الجوال'      => $employee->phone,
                'البريد الإلكتروني' => $employee->email,
                'القسم'           => $employee->department,
                'المسمى الوظيفي' => $employee->position,
                'تاريخ المباشرة' => $employee->start_date?->format('Y-m-d'),
                'تاريخ نهاية العقد' => $employee->end_date?->format('Y-m-d') ?? 'مفتوح',
            ] as $label => $value)
            <div class="info-row">
                <span class="label">{{ $label }}</span>
                <span class="value">{{ $value ?? '-' }}</span>
            </div>
            @endforeach
        </div>

        {{-- تحديث الصورة والسيرة الذاتية --}}
        <div class="card">
            <h5 style="font-weight:700;margin-bottom:15px"><i class="bi bi-upload"></i> تحديث الصورة والسيرة الذاتية</h5>
            @if($errors->any())
            <div style="background:#fee2e2;color:#dc2626;padding:10px;border-radius:8px;margin-bottom:15px;font-size:13px">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('portal.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label style="font-size:14px;font-weight:600;margin-bottom:8px;display:block">الصورة الشخصية</label>
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px">
                            <div style="width:60px;height:60px;border-radius:50%;overflow:hidden;background:#e5e7eb;flex-shrink:0;border:2px solid #e5e7eb;display:flex;align-items:center;justify-content:center" id="new-photo-preview">
                                @if($employee->photo)
                                    <img src="{{ Storage::disk('public')->url($employee->photo) }}" style="width:60px;height:60px;object-fit:cover">
                                @else
                                    <i class="bi bi-person" style="font-size:28px;color:#9ca3af"></i>
                                @endif
                            </div>
                            <div style="flex:1">
                                <input type="file" name="photo" id="new-photo-input" class="form-control" accept="image/jpg,image/jpeg,image/png" style="font-size:13px">
                                <div style="color:#9ca3af;font-size:11px;margin-top:4px">JPG/PNG — حد أقصى 2MB</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label style="font-size:14px;font-weight:600;margin-bottom:8px;display:block">السيرة الذاتية</label>
                        @if($employee->cv_file)
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:8px 12px;margin-bottom:8px;display:flex;align-items:center;gap:8px;font-size:13px">
                            <i class="bi bi-file-earmark-text" style="color:#16a34a;font-size:16px"></i>
                            <span style="color:#15803d">يوجد CV محفوظ</span>
                            <a href="{{ Storage::disk('public')->url($employee->cv_file) }}" target="_blank" style="color:#2563eb;margin-right:auto;font-size:12px">
                                <i class="bi bi-download"></i> تحميل
                            </a>
                        </div>
                        @endif
                        <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx" style="font-size:13px">
                        <div style="color:#9ca3af;font-size:11px;margin-top:4px">
                            {{ $employee->cv_file ? 'اترك فارغاً للإبقاء على الملف الحالي' : 'PDF / DOC / DOCX — حد أقصى 5MB' }}
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-action" style="font-size:14px;padding:10px 24px">
                            <i class="bi bi-cloud-upload"></i> حفظ التحديثات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('new-photo-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('new-photo-preview').innerHTML =
            `<img src="${e.target.result}" style="width:60px;height:60px;object-fit:cover;border-radius:50%">`;
    };
    reader.readAsDataURL(file);
});
</script>

@endif
@endsection
