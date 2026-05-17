@extends('layouts.app')
@section('title', 'إدارة الشركات')
@section('content')

<div class="top-header">
    <h4>إدارة الشركات</h4>
    <a href="{{ route('companies.create') }}" class="btn btn-add"><i class="bi bi-plus-lg"></i> إضافة شركة</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card mb-3"><div class="card-body" style="padding:15px">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="بحث بالاسم أو المدينة..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="is_active" class="form-select">
                <option value="">كل الحالات</option>
                <option value="1" {{ request('is_active')==='1'?'selected':'' }}>نشطة</option>
                <option value="0" {{ request('is_active')==='0'?'selected':'' }}>غير نشطة</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-save flex-fill">بحث</button>
            <a href="{{ route('companies.index') }}" class="btn btn-back">مسح</a>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة الشركات</span>
        <span style="color:#9ca3af;font-size:13px">{{ $companies->total() }} شركة</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>الشركة</th><th>السجل التجاري</th><th>المسؤول</th><th>الجوال</th><th>المدينة</th><th>الحالة</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                @forelse($companies as $co)
                <tr>
                    <td>{{ $loop->iteration + ($companies->currentPage()-1)*$companies->perPage() }}</td>
                    <td style="font-weight:600">{{ $co->name }}</td>
                    <td style="font-size:13px">{{ $co->commercial_register ?? '-' }}</td>
                    <td style="font-size:13px">{{ $co->contact_person ?? '-' }}</td>
                    <td style="font-size:13px">{{ $co->phone ?? '-' }}</td>
                    <td style="font-size:13px">{{ $co->city ?? '-' }}</td>
                    <td>
                        @if($co->is_active) <span class="badge-active">نشطة</span>
                        @else <span class="badge-inactive">غير نشطة</span> @endif
                    </td>
                    <td>
                        <a href="{{ route('companies.edit', $co->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('companies.destroy', $co->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-delete" onclick="return confirm('حذف الشركة؟')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-building" style="font-size:30px"></i><p class="mt-2">لا توجد شركات</p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($companies->hasPages())
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px">{{ $companies->links() }}</div>
    @endif
</div>
@endsection
