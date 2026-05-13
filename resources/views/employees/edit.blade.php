@extends('layouts.app')

@section('title', 'تعديل موظف')

@section('content')

<div class="top-header">
    <h4>تعديل بيانات الموظف</h4>
    <a href="{{ route('employees.index') }}" class="btn btn-back">رجوع</a>
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
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-title">البيانات الأساسية</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الاسم *</label>
                    <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">رقم الهوية *</label>
                    <input type="text" name="employee_number" class="form-control" value="{{ $employee->employee_number }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">رقم الجوال</label>
                    <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الإيميل</label>
                    <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">القسم</label>
                    <input type="text" name="department" class="form-control" value="{{ $employee->department }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">المسمى الوظيفي</label>
                    <input type="text" name="position" class="form-control" value="{{ $employee->position }}">
                </div>
            </div>

            <div class="section-title">بيانات العقد</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">تاريخ المباشرة</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $employee->start_date }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">تاريخ فسخ العقد</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $employee->end_date }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">حالة العقد</label>
                    <select name="contract_status" class="form-select">
                        <option value="active" @if($employee->contract_status == 'active') selected @endif>ساري</option>
                        <option value="inactive" @if($employee->contract_status == 'inactive') selected @endif>منتهي</option>
                        <option value="pending" @if($employee->contract_status == 'pending') selected @endif>معلق</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">حالة الموظف</label>
                    <select name="status" class="form-select">
                        <option value="active" @if($employee->status == 'active') selected @endif>نشط</option>
                        <option value="inactive" @if($employee->status == 'inactive') selected @endif>غير نشط</option>
                    </select>
                </div>
            </div>

            {{-- الحقول المخصصة --}}
            @if(count($customFields) > 0)
            <div class="section-title">حقول إضافية</div>
            <div class="row g-3 mb-4">
                @foreach($customFields as $field)
                @php $value = $customValues[$field->id] ?? ''; @endphp
                <div class="col-md-6">
                    <label class="form-label">
                        {{ $field->field_label }}
                        @if($field->is_required) * @endif
                    </label>

                    @if($field->field_type == 'textarea')
                        <textarea name="custom_fields[{{ $field->id }}]" class="form-control" rows="3" @if($field->is_required) required @endif>{{ $value }}</textarea>
                    @elseif($field->field_type == 'select')
                        <select name="custom_fields[{{ $field->id }}]" class="form-select" @if($field->is_required) required @endif>
                            <option value="">-- اختر --</option>
                            @foreach(explode(',', $field->options) as $option)
                                <option value="{{ trim($option) }}" @if(trim($option) == $value) selected @endif>{{ trim($option) }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{ $field->field_type }}" name="custom_fields[{{ $field->id }}]" class="form-control" value="{{ $value }}" @if($field->is_required) required @endif>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <button type="submit" class="btn btn-save">حفظ التعديل</button>
            <a href="{{ route('employees.index') }}" class="btn btn-back">إلغاء</a>
        </form>
    </div>
</div>

@endsection