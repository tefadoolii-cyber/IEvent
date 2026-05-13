@extends('layouts.app')

@section('title', 'تعديل حقل مخصص')

@section('content')

<div class="top-header">
    <h4>تعديل: {{ $customField->field_label }}</h4>
    <a href="{{ route('custom-fields.index') }}" class="btn btn-back">رجوع</a>
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
        <form action="{{ route('custom-fields.update', $customField->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الجدول *</label>
                    <select name="table_name" class="form-select" required>
                        <option value="employees"  @if($customField->table_name=='employees') selected @endif>الموظفين</option>
                        <option value="attendance" @if($customField->table_name=='attendance') selected @endif>الحضور</option>
                        <option value="contracts"  @if($customField->table_name=='contracts') selected @endif>العقود</option>
                        <option value="companies"  @if($customField->table_name=='companies') selected @endif>الشركات</option>
                        <option value="locations"  @if($customField->table_name=='locations') selected @endif>المواقع</option>
                        <option value="tasks"      @if($customField->table_name=='tasks') selected @endif>المهام</option>
                        <option value="visits"     @if($customField->table_name=='visits') selected @endif>الزيارات</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">نوع الحقل *</label>
                    <select name="field_type" class="form-select" required onchange="toggleOptions(this)">
                        <option value="text"     @if($customField->field_type=='text') selected @endif>نص</option>
                        <option value="number"   @if($customField->field_type=='number') selected @endif>رقم</option>
                        <option value="date"     @if($customField->field_type=='date') selected @endif>تاريخ</option>
                        <option value="select"   @if($customField->field_type=='select') selected @endif>قائمة منسدلة</option>
                        <option value="textarea" @if($customField->field_type=='textarea') selected @endif>نص طويل</option>
                        <option value="email"    @if($customField->field_type=='email') selected @endif>بريد إلكتروني</option>
                        <option value="phone"    @if($customField->field_type=='phone') selected @endif>جوال</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">اسم العرض *</label>
                    <input type="text" name="field_label" class="form-control" value="{{ $customField->field_label }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المفتاح (إنجليزي) *</label>
                    <input type="text" name="field_key" class="form-control" value="{{ $customField->field_key }}" required>
                </div>
                <div class="col-md-12" id="optionsField" style="display:{{ $customField->field_type=='select' ? 'block' : 'none' }}">
                    <label class="form-label">الخيارات (افصل بفاصلة)</label>
                    <input type="text" name="options" class="form-control" value="{{ $customField->options }}" placeholder="مثال: نشط,غير نشط">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الترتيب</label>
                    <input type="number" name="order" class="form-control" value="{{ $customField->order }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">إلزامي؟</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_required" value="1" class="form-check-input" id="isRequired" @if($customField->is_required) checked @endif>
                        <label class="form-check-label" for="isRequired">نعم، الحقل إلزامي</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-save">حفظ التعديل</button>
            <a href="{{ route('custom-fields.index') }}" class="btn btn-back">إلغاء</a>
        </form>
    </div>
</div>

<script>
function toggleOptions(el) {
    document.getElementById('optionsField').style.display = (el.value === 'select') ? 'block' : 'none';
}
</script>

@endsection