@extends('layouts.app')

@section('title', 'إضافة عقد')

@section('content')

<div class="top-header">
    <h4>إضافة عقد جديد</h4>
    <a href="{{ route('contracts.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <p class="mb-0">{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-title">بيانات العقد</div>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">الموظف *</label>
                    <select name="employee_id" id="employee_id" class="form-select" required>
                        <option value="">-- اختر موظف --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} - {{ $employee->employee_number }}{{ $employee->department ? ' - '.$employee->department : '' }}{{ $employee->position ? ' - '.$employee->position : '' }}
                            </option>
                        @endforeach
                    </select>

                    {{-- بطاقة بيانات الموظف --}}
                    <div id="emp-info-card" style="display:none;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px;margin-top:10px">
                        <div style="font-weight:700;color:#15803d;font-size:13px;margin-bottom:10px">
                            <i class="bi bi-person-check"></i> بيانات الموظف المختار
                        </div>
                        <div class="row g-2" id="emp-info-content"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">المسمى الوظيفي</label>
                    <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}" placeholder="مثال: مطور برمجيات">
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ البداية *</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ النهاية</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">الراتب الشهري (ر.س)</label>
                    <input type="number" name="salary" class="form-control" value="{{ old('salary') }}" min="0" step="0.01" placeholder="0.00">
                </div>
                <div class="col-md-4">
                    <label class="form-label">حالة العقد *</label>
                    <select name="status" class="form-select" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="sent"  {{ old('status') == 'sent'  ? 'selected' : '' }}>مُرسل</option>
                        <option value="signed" {{ old('status') == 'signed' ? 'selected' : '' }}>موقّع</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                </div>
            </div>

            <div class="section-title">ملف العقد</div>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">رفع ملف العقد PDF</label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                    <div style="color:#9ca3af;font-size:12px;margin-top:4px">الحد الأقصى 10 ميجابايت - PDF فقط</div>
                </div>
            </div>

            <div class="section-title">بنود العقد</div>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">بنود وشروط العقد</label>
                    <textarea name="terms" class="form-control" rows="6" placeholder="اكتب بنود وشروط العقد هنا...">{{ old('terms') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> حفظ العقد
                </button>
                <a href="{{ route('contracts.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<script>
const empDataUrl = '{{ url("employees") }}/';

function loadEmployeeData(id, autofill) {
    if (!id) {
        document.getElementById('emp-info-card').style.display = 'none';
        return;
    }
    fetch(empDataUrl + id + '/data')
        .then(r => r.json())
        .then(data => {
            if (autofill) {
                if (data.position)   document.getElementById('position').value   = data.position;
                if (data.start_date) document.getElementById('start_date').value = data.start_date;
                if (data.end_date)   document.getElementById('end_date').value   = data.end_date;
            }
            document.getElementById('emp-info-content').innerHTML = buildInfoCard(data);
            document.getElementById('emp-info-card').style.display = 'block';
        });
}

function buildInfoCard(d) {
    const fields = [
        ['رقم الهوية',      d.employee_number],
        ['القسم',           d.department],
        ['المسمى الوظيفي',  d.position],
        ['الجوال',          d.phone],
        ['البريد الإلكتروني', d.email],
        ['تاريخ المباشرة',  d.start_date],
    ];
    return fields.map(([label, val]) => `
        <div class="col-md-4 col-6">
            <div style="font-size:11px;color:#6b7280">${label}</div>
            <div style="font-weight:600;font-size:13px;color:#1a1a2e">${val || '-'}</div>
        </div>
    `).join('');
}

document.getElementById('employee_id').addEventListener('change', function() {
    loadEmployeeData(this.value, true);
});

// If old value was submitted (form re-display after error)
@if(old('employee_id'))
loadEmployeeData('{{ old("employee_id") }}', false);
@endif
</script>

@endsection
