@extends('layouts.app')
@section('title', 'إدارة الإسنادات')
@section('content')

<div class="top-header">
    <h4>إدارة الإسنادات</h4>
    <a href="{{ route('assignments.create') }}" class="btn btn-add"><i class="bi bi-plus-lg"></i> إضافة إسناد</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card mb-3"><div class="card-body" style="padding:15px">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="بحث باسم الموظف..." value="{{ request('search') }}"></div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">كل الحالات</option>
                @foreach(['active'=>'نشط','completed'=>'منتهي','cancelled'=>'ملغي'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('status')==$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="location_id" class="form-select">
                <option value="">كل المواقع</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}" {{ request('location_id')==$loc->id?'selected':'' }}>{{ $loc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="company_id" class="form-select">
                <option value="">كل الشركات</option>
                @foreach($companies as $co)
                    <option value="{{ $co->id }}" {{ request('company_id')==$co->id?'selected':'' }}>{{ $co->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-save flex-fill">بحث</button>
            <a href="{{ route('assignments.index') }}" class="btn btn-back">مسح</a>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة الإسنادات</span>
        <span style="color:#9ca3af;font-size:13px">{{ $assignments->total() }} إسناد</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>الموظف</th><th>الموقع</th><th>الشركة</th><th>الدور</th><th>من</th><th>إلى</th><th>الحالة</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                @forelse($assignments as $asgn)
                @php
                    $sColors = ['active'=>'#16a34a','completed'=>'#6b7280','cancelled'=>'#dc2626'];
                    $sBgs    = ['active'=>'#dcfce7','completed'=>'#f3f4f6','cancelled'=>'#fee2e2'];
                @endphp
                <tr>
                    <td>{{ $loop->iteration + ($assignments->currentPage()-1)*$assignments->perPage() }}</td>
                    <td style="font-weight:600">{{ $asgn->employee->name ?? '-' }}</td>
                    <td>
                        @if($asgn->location)
                            <div style="font-size:13px;font-weight:600">{{ $asgn->location->name }}</div>
                            @if($asgn->location->region)
                            <div style="font-size:11px;color:#9ca3af">{{ $asgn->location->region->name }}</div>
                            @endif
                        @else
                            <span style="color:#9ca3af">—</span>
                        @endif
                    </td>
                    <td style="font-size:13px">{{ $asgn->company->name ?? '-' }}</td>
                    <td style="font-size:13px">{{ $asgn->role ?? '-' }}</td>
                    <td style="font-size:13px">{{ $asgn->start_date?->format('Y-m-d') ?? '-' }}</td>
                    <td style="font-size:13px">{{ $asgn->end_date?->format('Y-m-d') ?? 'مفتوح' }}</td>
                    <td><span style="background:{{ $sBgs[$asgn->status]??'#f3f4f6' }};color:{{ $sColors[$asgn->status]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:12px">{{ $asgn->status_label }}</span></td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="{{ route('assignments.show', $asgn->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('assignments.edit', $asgn->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('assignments.destroy', $asgn->id) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف الإسناد؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-person-check" style="font-size:30px"></i><p class="mt-2">لا توجد إسنادات</p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($assignments->hasPages())
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px">{{ $assignments->links() }}</div>
    @endif
</div>
@endsection
