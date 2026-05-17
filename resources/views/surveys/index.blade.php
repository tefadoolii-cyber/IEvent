@extends('layouts.app')
@section('title', 'الاستبيانات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-clipboard-data"></i> الاستبيانات</h4>
    <a href="{{ route('surveys.create') }}" class="btn btn-add"><i class="bi bi-plus-lg"></i> استبيان جديد</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3 mb-4">
    @foreach([
        ['val'=>$stats['total'],  'label'=>'إجمالي',  'color'=>'#374151'],
        ['val'=>$stats['draft'],  'label'=>'مسودة',   'color'=>'#6b7280'],
        ['val'=>$stats['active'], 'label'=>'نشطة',    'color'=>'#16a34a'],
        ['val'=>$stats['closed'], 'label'=>'مغلقة',   'color'=>'#dc2626'],
    ] as $s)
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid {{ $s['color'] }}">
            <div style="font-size:26px;font-weight:800;color:{{ $s['color'] }}">{{ $s['val'] }}</div>
            <div style="font-size:12px;color:#9ca3af">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="عنوان الاستبيان..." value="{{ request('search') }}" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="draft"  {{ request('status')=='draft'  ?'selected':'' }}>مسودة</option>
                <option value="active" {{ request('status')=='active' ?'selected':'' }}>نشط</option>
                <option value="closed" {{ request('status')=='closed' ?'selected':'' }}>مغلق</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        @if(request()->hasAny(['search','status']))
        <div class="col-auto"><a href="{{ route('surveys.index') }}" class="btn btn-back" style="font-size:13px">مسح</a></div>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($surveys->count())
        @php
            $sc=['draft'=>'#6b7280','active'=>'#16a34a','closed'=>'#dc2626'];
            $sb=['draft'=>'#f3f4f6','active'=>'#dcfce7','closed'=>'#fee2e2'];
        @endphp
        <table class="table mb-0">
            <thead>
                <tr><th>الاستبيان</th><th>الأسئلة</th><th>الردود</th><th>الحالة</th><th>بداية/نهاية</th><th>أنشأه</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($surveys as $sv)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $sv->title }}</div>
                        @if($sv->description)
                        <div style="font-size:11px;color:#9ca3af">{{ Str::limit($sv->description, 50) }}</div>
                        @endif
                    </td>
                    <td style="font-size:13px;text-align:center">{{ $sv->questions_count }}</td>
                    <td style="font-size:13px;text-align:center">{{ $sv->responses_count }}</td>
                    <td>
                        <span style="background:{{ $sb[$sv->status]??'#f3f4f6' }};color:{{ $sc[$sv->status]??'#6b7280' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $sv->status_label }}
                        </span>
                    </td>
                    <td style="font-size:11px;color:#9ca3af">
                        {{ $sv->starts_at?->format('Y-m-d') ?? '—' }}
                        @if($sv->ends_at) ← {{ $sv->ends_at->format('Y-m-d') }} @endif
                    </td>
                    <td style="font-size:12px">{{ $sv->creator?->name ?? '—' }}</td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="{{ route('surveys.show', $sv->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('surveys.edit', $sv->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('surveys.destroy', $sv->id) }}" method="POST" onsubmit="return confirm('حذف هذا الاستبيان؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px">{{ $surveys->withQueryString()->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-clipboard-data" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد استبيانات</p>
        </div>
        @endif
    </div>
</div>
@endsection
