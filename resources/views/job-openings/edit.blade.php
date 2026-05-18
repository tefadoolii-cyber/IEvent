@extends('layouts.app')
@section('title', 'تعديل وظيفة')
@section('content')

<div class="top-header">
    <h4>تعديل وظيفة: {{ $jobOpening->title }}</h4>
    <a href="{{ route('job-openings.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<form action="{{ route('job-openings.update', $jobOpening->id) }}" method="POST">
    @csrf @method('PUT')
    @include('job-openings._form', ['opening' => $jobOpening])
    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ التعديلات</button>
        <a href="{{ route('apply.form', $jobOpening->id) }}" target="_blank" class="btn btn-edit"><i class="bi bi-eye"></i> معاينة</a>
        <a href="{{ route('job-openings.index') }}" class="btn btn-back">إلغاء</a>
    </div>
</form>

@endsection
