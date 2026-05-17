@extends('layouts.app')
@section('title', 'الباقات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-box-seam"></i> إدارة الباقات</h4>
    <a href="{{ route('packages.create') }}" class="btn btn-add"><i class="bi bi-plus-lg"></i> باقة جديدة</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3 mb-4">
    @foreach([
        ['val'=>$stats['total'],    'label'=>'إجمالي',    'color'=>'#374151'],
        ['val'=>$stats['active'],   'label'=>'نشطة',      'color'=>'#16a34a'],
        ['val'=>$stats['inactive'], 'label'=>'غير نشطة',  'color'=>'#dc2626'],
    ] as $s)
    <div class="col-6 col-md-4">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid {{ $s['color'] }}">
            <div style="font-size:26px;font-weight:800;color:{{ $s['color'] }}">{{ $s['val'] }}</div>
            <div style="font-size:12px;color:#9ca3af">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="اسم الباقة..." value="{{ request('search') }}" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="active"   {{ request('status')=='active'   ?'selected':'' }}>نشطة</option>
                <option value="inactive" {{ request('status')=='inactive' ?'selected':'' }}>غير نشطة</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="company_id" class="form-select" style="font-size:13px">
                <option value="">كل الشركات</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ request('company_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        @if(request()->hasAny(['search','status','company_id']))
        <div class="col-auto"><a href="{{ route('packages.index') }}" class="btn btn-back" style="font-size:13px">مسح</a></div>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($packages->count())
        <table class="table mb-0">
            <thead>
                <tr><th>الباقة</th><th>الشركة</th><th>السعر</th><th>الخدمات</th><th>الحالة</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($packages as $pkg)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $pkg->name }}</div>
                        @if($pkg->description)
                        <div style="font-size:11px;color:#9ca3af">{{ Str::limit($pkg->description, 50) }}</div>
                        @endif
                    </td>
                    <td style="font-size:13px">{{ $pkg->company?->name ?? '—' }}</td>
                    <td style="font-size:13px;font-weight:600">{{ number_format($pkg->price, 2) }} ر.س</td>
                    <td>
                        @if($pkg->services)
                            @foreach(array_slice($pkg->services, 0, 3) as $s)
                                <span style="background:#f3f4f6;color:#374151;padding:2px 8px;border-radius:12px;font-size:11px;margin-left:3px">{{ $s }}</span>
                            @endforeach
                            @if(count($pkg->services) > 3)
                                <span style="font-size:11px;color:#9ca3af">+{{ count($pkg->services)-3 }}</span>
                            @endif
                        @else
                            <span style="color:#9ca3af;font-size:12px">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="background:{{ $pkg->status==='active'?'#dcfce7':'#fee2e2' }};color:{{ $pkg->status==='active'?'#16a34a':'#dc2626' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $pkg->status_label }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="{{ route('packages.edit', $pkg->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('حذف هذه الباقة؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px">{{ $packages->withQueryString()->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-box-seam" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد باقات</p>
        </div>
        @endif
    </div>
</div>
@endsection
