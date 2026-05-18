@php
    $enabledKeys  = collect($opening?->fields ?? [])->pluck('key')->toArray();
    $requiredKeys = collect($opening?->fields ?? [])->where('required', true)->pluck('key')->toArray();
@endphp

{{-- بيانات الوظيفة --}}
<div class="card mb-3">
    <div class="card-header" style="font-weight:600"><i class="bi bi-briefcase me-1"></i>بيانات الوظيفة</div>
    <div class="card-body" style="padding:25px">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">المسمى الوظيفي *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $opening?->title) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">القسم</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $opening?->department) }}" placeholder="مثال: تقنية المعلومات">
            </div>
            <div class="col-md-4">
                <label class="form-label">الموعد الأخير للتقديم</label>
                <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $opening?->deadline?->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحد الأقصى للمتقدمين</label>
                <input type="number" name="max_applicants" class="form-control" min="1" value="{{ old('max_applicants', $opening?->max_applicants) }}" placeholder="اتركه فارغاً بلا حد">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch" style="margin-bottom:8px">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active', $opening ? ($opening->is_active ? '1' : '') : '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active" style="font-size:14px">وظيفة نشطة (تظهر للمتقدمين)</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">وصف الوظيفة</label>
                <textarea name="description" class="form-control" rows="3" placeholder="المتطلبات، المهام، الشروط...">{{ old('description', $opening?->description) }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- حقول نموذج التقديم --}}
<div class="card">
    <div class="card-header" style="font-weight:600">
        <i class="bi bi-input-cursor-text me-1"></i>حقول نموذج التقديم
        <span style="color:#9ca3af;font-size:12px;font-weight:400;margin-right:10px">فعّل الحقول التي تريدها وحدد أيها إلزامي</span>
    </div>
    <div class="card-body" style="padding:20px">

        <div class="row g-2">
            @foreach($availableFields as $key => $def)
            @php
                $isEnabled  = in_array($key, old('field_enabled', $enabledKeys));
                $isRequired = in_array($key, old('field_required', $requiredKeys));
                $typeIcons  = ['text'=>'input-cursor','email'=>'envelope','tel'=>'phone','date'=>'calendar','number'=>'hash','select'=>'list','textarea'=>'text-paragraph','image'=>'image','file'=>'file-earmark-pdf'];
                $typeIcon   = $typeIcons[$def['type']] ?? 'input-cursor';
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="field-card {{ $isEnabled ? 'enabled' : '' }}" id="card-{{ $key }}"
                     style="border:2px solid {{ $isEnabled ? '#2563eb' : '#e5e7eb' }};border-radius:10px;padding:12px 14px;transition:all 0.2s;background:{{ $isEnabled ? '#eff6ff' : 'white' }}">

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-{{ $typeIcon }}" style="color:{{ $isEnabled ? '#2563eb' : '#9ca3af' }};font-size:16px"></i>
                            <span style="font-weight:600;font-size:13px">{{ $def['label'] }}</span>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input field-toggle" type="checkbox"
                                   name="field_enabled[]" value="{{ $key }}"
                                   id="enable_{{ $key }}"
                                   data-key="{{ $key }}"
                                   {{ $isEnabled ? 'checked' : '' }}
                                   onchange="toggleField('{{ $key }}', this.checked)">
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <span style="font-size:11px;color:#9ca3af;background:#f3f4f6;padding:2px 8px;border-radius:10px">{{ $def['type'] }}</span>
                        <div class="form-check mb-0" id="req-wrap-{{ $key }}" style="display:{{ $isEnabled ? 'flex' : 'none' }}!important;align-items:center;gap:4px">
                            <input class="form-check-input" type="checkbox"
                                   name="field_required[]" value="{{ $key }}"
                                   id="req_{{ $key }}"
                                   {{ $isRequired ? 'checked' : '' }}>
                            <label class="form-check-label" for="req_{{ $key }}" style="font-size:12px;color:#dc2626;cursor:pointer">إلزامي</label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="background:#fef9c3;border:1px solid #fde047;border-radius:8px;padding:10px 14px;margin-top:16px;font-size:13px">
            <i class="bi bi-info-circle me-1" style="color:#d97706"></i>
            فعّل الحقل بالمفتاح على اليمين، وإن أردته إلزامياً ضع علامة <strong>إلزامي</strong>.
            الحقول غير المفعّلة لن تظهر للمتقدمين.
        </div>
    </div>
</div>

<script>
function toggleField(key, enabled) {
    const card    = document.getElementById('card-' + key);
    const reqWrap = document.getElementById('req-wrap-' + key);
    const reqChk  = document.getElementById('req_' + key);
    const icon    = card.querySelector('.bi');

    if (enabled) {
        card.style.borderColor  = '#2563eb';
        card.style.background   = '#eff6ff';
        icon.style.color        = '#2563eb';
        reqWrap.style.display   = 'flex';
    } else {
        card.style.borderColor  = '#e5e7eb';
        card.style.background   = 'white';
        icon.style.color        = '#9ca3af';
        reqWrap.style.display   = 'none';
        if (reqChk) reqChk.checked = false;
    }
}
</script>
