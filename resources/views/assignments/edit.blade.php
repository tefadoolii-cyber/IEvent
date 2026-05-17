@extends('layouts.app')
@section('title', 'تعديل الإسناد')
@section('content')

<div class="top-header">
    <h4>تعديل الإسناد</h4>
    <a href="{{ route('assignments.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card"><div class="card-body" style="padding:25px">
    <form action="{{ route('assignments.update', $assignment->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">الموظف *</label>
                <select name="employee_id" id="asgn_employee_id" class="form-select" required>
                    <option value="">-- اختر موظف --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}"
                            data-phone="{{ $emp->phone }}"
                            data-department="{{ $emp->department }}"
                            data-position="{{ $emp->position }}"
                            data-number="{{ $emp->employee_number }}"
                            {{ old('employee_id', $assignment->employee_id) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }} - {{ $emp->employee_number }}{{ $emp->department ? ' - '.$emp->department : '' }}{{ $emp->position ? ' - '.$emp->position : '' }}
                        </option>
                    @endforeach
                </select>
                <div id="asgn-emp-info" style="display:none;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px;margin-top:8px;font-size:13px">
                    <div class="row g-1">
                        <div class="col-4"><span style="color:#6b7280;font-size:11px">القسم</span><div id="ae-dept" style="font-weight:600;font-size:13px"></div></div>
                        <div class="col-4"><span style="color:#6b7280;font-size:11px">المسمى</span><div id="ae-pos" style="font-weight:600;font-size:13px"></div></div>
                        <div class="col-4"><span style="color:#6b7280;font-size:11px">الجوال</span><div id="ae-phone" style="font-weight:600;font-size:13px"></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">المشرف</label>
                <select name="supervisor_id" class="form-select">
                    <option value="">-- لا يوجد --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('supervisor_id', $assignment->supervisor_id) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }} - {{ $emp->employee_number }}{{ $emp->department ? ' - '.$emp->department : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">الموقع</label>
                <select name="location_id" id="locSelect" class="form-select" onchange="showLocInfo(this)">
                    <option value="">-- لا يوجد --</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}"
                            data-region="{{ $loc->region?->name ?? '' }}"
                            data-address="{{ $loc->address ?? '' }}"
                            data-lat="{{ $loc->lat ?? '' }}"
                            data-lng="{{ $loc->lng ?? '' }}"
                            {{ old('location_id', $assignment->location_id) == $loc->id ? 'selected' : '' }}>
                            {{ $loc->name }}{{ $loc->region ? ' — '.$loc->region->name : '' }}{{ $loc->city ? ' ('.$loc->city.')' : '' }}
                        </option>
                    @endforeach
                </select>
                <div id="loc-info" style="display:none;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px;margin-top:8px;font-size:12px">
                    <div id="loc-region" style="color:#15803d;margin-bottom:2px"></div>
                    <div id="loc-address" style="color:#6b7280"></div>
                    <a id="loc-maps" href="#" target="_blank" style="font-size:11px;color:#1d4ed8;display:none"><i class="bi bi-pin-map"></i> Google Maps</a>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">الشركة</label>
                <select name="company_id" class="form-select">
                    <option value="">-- لا يوجد --</option>
                    @foreach($companies as $co)
                        <option value="{{ $co->id }}" {{ old('company_id', $assignment->company_id) == $co->id ? 'selected' : '' }}>{{ $co->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الدور / المهمة</label>
                <input type="text" name="role" class="form-control" value="{{ old('role', $assignment->role) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ البداية *</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $assignment->start_date?->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ النهاية</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $assignment->end_date?->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة *</label>
                <select name="status" class="form-select" required>
                    @foreach(['active'=>'نشط','completed'=>'منتهي','cancelled'=>'ملغي'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status', $assignment->status) == $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $assignment->notes) }}</textarea>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ التعديلات</button>
            <a href="{{ route('assignments.show', $assignment->id) }}" class="btn btn-edit">عرض</a>
            <a href="{{ route('assignments.index') }}" class="btn btn-back">إلغاء</a>
        </div>
    </form>
</div></div>

<script>
function showLocInfo(sel) {
    const opt  = sel.options[sel.selectedIndex];
    const info = document.getElementById('loc-info');
    if (!opt.value) { info.style.display = 'none'; return; }
    document.getElementById('loc-region').textContent  = opt.dataset.region  ? '📍 ' + opt.dataset.region  : '';
    document.getElementById('loc-address').textContent = opt.dataset.address ? opt.dataset.address : '';
    const mapsLink = document.getElementById('loc-maps');
    if (opt.dataset.lat && opt.dataset.lng) {
        mapsLink.href = 'https://www.google.com/maps?q=' + opt.dataset.lat + ',' + opt.dataset.lng;
        mapsLink.style.display = 'inline';
    } else {
        mapsLink.style.display = 'none';
    }
    info.style.display = 'block';
}
const locSelEl = document.getElementById('locSelect');
if (locSelEl.value) showLocInfo(locSelEl);

function updateAsgnEmpInfo(select) {
    const opt = select.options[select.selectedIndex];
    const info = document.getElementById('asgn-emp-info');
    if (!opt.value) { info.style.display = 'none'; return; }
    document.getElementById('ae-dept').textContent  = opt.dataset.department || '-';
    document.getElementById('ae-pos').textContent   = opt.dataset.position   || '-';
    document.getElementById('ae-phone').textContent = opt.dataset.phone      || '-';
    info.style.display = 'block';
}
const asgnSel = document.getElementById('asgn_employee_id');
asgnSel.addEventListener('change', function() { updateAsgnEmpInfo(this); });
// Show on load for existing employee
if (asgnSel.value) updateAsgnEmpInfo(asgnSel);
</script>

@endsection
