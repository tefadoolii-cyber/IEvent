@extends('layouts.app')

@section('title', 'تعديل إدارة')

@section('content')

<div class="top-header">
    <h4>تعديل الإدارة: {{ $module->name }}</h4>
    <a href="{{ route('modules.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <p class="mb-0">{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('modules.update', $module->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">اسم الإدارة *</label>
                    <input type="text" name="name" class="form-control" value="{{ $module->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المفتاح (إنجليزي) *</label>
                    <input type="text" name="key" class="form-control" value="{{ $module->key }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الإدارة الرئيسية *</label>
                    <select name="parent" class="form-select" required>
                        <option value="hr"      @if($module->parent=='hr') selected @endif>إدارة الموارد البشرية</option>
                        <option value="data"    @if($module->parent=='data') selected @endif>إدارة البيانات</option>
                        <option value="ops"     @if($module->parent=='ops') selected @endif>إدارة التشغيل</option>
                        <option value="quality" @if($module->parent=='quality') selected @endif>إدارة الجودة</option>
                        <option value="it"      @if($module->parent=='it') selected @endif>إدارة تقنية المعلومات</option>
                        <option value="finance" @if($module->parent=='finance') selected @endif>إدارة المالية</option>
                        <option value="other"   @if($module->parent=='other') selected @endif>أخرى</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الأيقونة</label>
                    <input type="text" name="icon" class="form-control" value="{{ $module->icon }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الرابط</label>
                    <input type="text" name="route" class="form-control" value="{{ $module->route }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الترتيب</label>
                    <input type="number" name="order" class="form-control" value="{{ $module->order }}">
                </div>
            </div>

            <button type="submit" class="btn btn-save">حفظ التعديل</button>
            <a href="{{ route