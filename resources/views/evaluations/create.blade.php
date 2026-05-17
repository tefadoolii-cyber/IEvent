@extends('layouts.app')
@section('title', 'إضافة تقييم')
@section('content')

<div class="top-header">
    <h4>إضافة تقييم جديد</h4>
    <a href="{{ route('evaluations.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('evaluations.store') }}" method="POST" id="evalForm">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الموظف *</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">-- اختر --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id')==$emp->id?'selected':'' }}>{{ $emp->name }} — {{ $emp->department ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الفترة * <small style="color:#9ca3af">(مثال: 2026-Q1)</small></label>
                    <input type="text" name="period" class="form-control" value="{{ old('period') }}" placeholder="2026-Q2" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="draft"     {{ old('status','draft')=='draft'     ?'selected':'' }}>مسودة</option>
                        <option value="submitted" {{ old('status')=='submitted' ?'selected':'' }}>مُقدَّم</option>
                        <option value="approved"  {{ old('status')=='approved'  ?'selected':'' }}>معتمد</option>
                    </select>
                </div>
            </div>

            {{-- معايير التقييم --}}
            @if($criteria->count())
            <div class="section-title">معايير التقييم</div>
            <div class="row g-3 mb-4" id="criteriaSection">
                @foreach($criteria as $cr)
                @php $key = 'criteria_'.$cr->id; @endphp
                <div class="col-md-6">
                    <label class="form-label" style="font-size:13px">{{ $cr->value_ar }}</label>
                    <div style="display:flex;align-items:center;gap:10px">
                        <input type="range" name="criteria[{{ $cr->id }}][score]" min="0" max="100" value="{{ old('criteria.'.$cr->id.'.score', 0) }}"
                               class="form-range" oninput="updateScore(this)">
                        <span id="score_{{ $cr->id }}" style="font-weight:700;min-width:36px;text-align:center">{{ old('criteria.'.$cr->id.'.score', 0) }}</span>
                        <input type="hidden" name="criteria[{{ $cr->id }}][label]" value="{{ $cr->value_ar }}">
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">الدرجة الإجمالية (0-100) *</label>
                    <input type="number" name="total_score" id="totalScore" class="form-control" value="{{ old('total_score', 0) }}" min="0" max="100" required>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="{{ route('evaluations.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<script>
function updateScore(input) {
    const id = input.name.match(/\[(\d+)\]/)[1];
    document.getElementById('score_' + id).textContent = input.value;
    // Auto-calc average of all criteria into total
    const ranges = document.querySelectorAll('[name^="criteria["]');
    if (ranges.length) {
        let sum = 0;
        ranges.forEach(r => { if(r.name.includes('[score]')) sum += parseInt(r.value); });
        document.getElementById('totalScore').value = Math.round(sum / ranges.length * 2);
    }
}
</script>
@endsection
