@extends('layouts.app')
@section('title', 'تعديل الشركة')
@section('content')

<div class="top-header">
    <h4>تعديل الشركة - {{ $company->name }}</h4>
    <a href="{{ route('companies.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card"><div class="card-body" style="padding:25px">
    <form action="{{ route('companies.update', $company->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">اسم الشركة *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$company->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">السجل التجاري</label>
                <input type="text" name="commercial_register" class="form-control" value="{{ old('commercial_register',$company->commercial_register) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">المسؤول</label>
                <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person',$company->contact_person) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">رقم الجوال</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone',$company->phone) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ old('email',$company->email) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">المدينة</label>
                <input type="text" name="city" class="form-control" value="{{ old('city',$company->city) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $company->is_active?'selected':'' }}>نشطة</option>
                    <option value="0" {{ !$company->is_active?'selected':'' }}>غير نشطة</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="form-control" value="{{ old('address',$company->address) }}">
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes',$company->notes) }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ التعديلات</button>
        <a href="{{ route('companies.index') }}" class="btn btn-back">إلغاء</a>
    </form>
</div></div>
@endsection
