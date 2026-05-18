@extends('layouts.app')
@section('title', 'إضافة وظيفة مفتوحة')
@section('content')

<div class="top-header">
    <h4>إضافة وظيفة مفتوحة</h4>
    <a href="{{ route('job-openings.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<form action="{{ route('job-openings.store') }}" method="POST">
    @csrf
    @include('job-openings._form', ['opening' => null])
    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
        <a href="{{ route('job-openings.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>

@endsection
