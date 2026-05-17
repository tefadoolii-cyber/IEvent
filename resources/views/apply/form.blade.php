@extends('layouts.public')

@section('title', 'التقديم على وظيفة')
@section('header-subtitle', 'تقديم طلب توظيف')

@section('content')

@if($errors->any())
<div class="alert alert-danger mb-4">
    <strong><i class="bi bi-exclamation-triangle-fill"></i> يرجى تصحيح الأخطاء التالية:</strong>
    <ul class="mb-0 mt-2 pe-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-10">

        <div class="pub-card" style="text-align:center;padding:28px;margin-bottom:20px">
            <div style="width:70px;height:70px;background:linear-gradient(135deg,#1a1a2e,#0f3460);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px">
                <i class="bi bi-person-lines-fill" style="color:white;font-size:30px"></i>
            </div>
            <h2 style="font-size:20px;font-weight:800;color:#1a1a2e;margin-bottom:6px">تقديم طلب توظيف</h2>
            <p style="color:#6b7280;font-size:13px;margin:0">يرجى ملء جميع البيانات المطلوبة بدقة. الحقول المميزة بـ <span class="required-star">*</span> إلزامية.</p>
        </div>

        <form action="{{ route('apply.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- البيانات الشخصية --}}
            <div class="pub-card">
                <div class="section-title"><i class="bi bi-person-badge"></i> البيانات الشخصية</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم الكامل <span class="required-star">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name') }}" placeholder="الاسم الرباعي" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم الهوية / الإقامة <span class="required-star">*</span></label>
                        <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror"
                               value="{{ old('id_number') }}" placeholder="1XXXXXXXXX" required>
                        @error('id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم الجوال <span class="required-star">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}" placeholder="05XXXXXXXX" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="example@email.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                               value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الجنسية</label>
                        <select name="nationality" class="form-select @error('nationality') is-invalid @enderror">
                            <option value="">-- اختر --</option>
                            @foreach($nationalities as $nat)
                                <option value="{{ is_string($nat) ? $nat : $nat->value_ar }}"
                                    {{ old('nationality') == (is_string($nat) ? $nat : $nat->value_ar) ? 'selected' : '' }}>
                                    {{ is_string($nat) ? $nat : $nat->value_ar }}
                                </option>
                            @endforeach
                        </select>
                        @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address') }}" placeholder="المدينة، الحي">
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- البيانات التعليمية والمهنية --}}
            <div class="pub-card">
                <div class="section-title"><i class="bi bi-mortarboard"></i> المؤهل والخبرة</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">المؤهل العلمي</label>
                        <select name="education_level" class="form-select @error('education_level') is-invalid @enderror">
                            <option value="">-- اختر --</option>
                            @foreach($educationLevels as $edu)
                                <option value="{{ is_string($edu) ? $edu : $edu->value_ar }}"
                                    {{ old('education_level') == (is_string($edu) ? $edu : $edu->value_ar) ? 'selected' : '' }}>
                                    {{ is_string($edu) ? $edu : $edu->value_ar }}
                                </option>
                            @endforeach
                        </select>
                        @error('education_level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">سنوات الخبرة</label>
                        <select name="experience_years" class="form-select @error('experience_years') is-invalid @enderror">
                            <option value="">-- اختر --</option>
                            <option value="0" {{ old('experience_years') == '0' ? 'selected' : '' }}>بدون خبرة</option>
                            <option value="1" {{ old('experience_years') == '1' ? 'selected' : '' }}>أقل من سنة</option>
                            <option value="2" {{ old('experience_years') == '2' ? 'selected' : '' }}>1 - 2 سنة</option>
                            <option value="3" {{ old('experience_years') == '3' ? 'selected' : '' }}>3 - 5 سنوات</option>
                            <option value="4" {{ old('experience_years') == '4' ? 'selected' : '' }}>6 - 10 سنوات</option>
                            <option value="5" {{ old('experience_years') == '5' ? 'selected' : '' }}>أكثر من 10 سنوات</option>
                        </select>
                        @error('experience_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الراتب المتوقع (ر.س)</label>
                        <input type="number" name="expected_salary" class="form-control @error('expected_salary') is-invalid @enderror"
                               value="{{ old('expected_salary') }}" placeholder="مثال: 8000" min="0">
                        @error('expected_salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">الوظيفة المطلوبة <span class="required-star">*</span></label>
                        <input type="text" name="desired_position" class="form-control @error('desired_position') is-invalid @enderror"
                               value="{{ old('desired_position') }}" placeholder="مثال: محاسب، مهندس مدني، مدير مشروع..." required>
                        @error('desired_position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">خطاب التقديم / ملاحظات إضافية</label>
                        <textarea name="cover_letter" class="form-control @error('cover_letter') is-invalid @enderror"
                                  rows="4" placeholder="اكتب نبذة مختصرة عن نفسك وأسباب تقديمك...">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- الصورة والسيرة الذاتية --}}
            <div class="pub-card">
                <div class="section-title"><i class="bi bi-paperclip"></i> الصورة الشخصية والسيرة الذاتية</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الصورة الشخصية</label>
                        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:8px">
                            <div id="photo-preview" style="width:80px;height:80px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;border:3px solid #e5e7eb">
                                <i class="bi bi-person" style="font-size:36px;color:#9ca3af"></i>
                            </div>
                            <div style="flex:1">
                                <input type="file" name="photo" id="photo-input" class="form-control @error('photo') is-invalid @enderror"
                                       accept="image/jpg,image/jpeg,image/png" style="font-size:13px">
                                <div style="color:#9ca3af;font-size:11px;margin-top:4px">JPG / PNG — الحد الأقصى 2MB</div>
                                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">السيرة الذاتية (CV) <span class="required-star">*</span></label>
                        <input type="file" name="cv_file" class="form-control @error('cv_file') is-invalid @enderror"
                               accept=".pdf,.doc,.docx" style="font-size:13px">
                        <div style="color:#9ca3af;font-size:11px;margin-top:4px">PDF / DOC / DOCX — الحد الأقصى 5MB</div>
                        @error('cv_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- الإرسال --}}
            <div class="pub-card">
                <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:10px;padding:14px 16px;margin-bottom:20px;font-size:13px;color:#92400e;display:flex;align-items:flex-start;gap:10px">
                    <i class="bi bi-info-circle-fill" style="font-size:16px;flex-shrink:0;margin-top:1px"></i>
                    <div>
                        بتقديم هذا الطلب، أقر بأن جميع المعلومات المذكورة صحيحة ودقيقة، وأن أي معلومة مغلوطة قد تؤدي إلى رفض الطلب أو إنهاء التوظيف.
                    </div>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-send-fill"></i> إرسال طلب التوظيف
                </button>
                <div style="text-align:center;margin-top:16px;font-size:13px;color:#6b7280">
                    هل لديك حساب؟ <a href="{{ route('login') }}" style="color:#0f3460;font-weight:600">تسجيل الدخول</a>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('photo-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('photo-preview').innerHTML =
            `<img src="${e.target.result}" style="width:80px;height:80px;object-fit:cover;border-radius:50%">`;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
