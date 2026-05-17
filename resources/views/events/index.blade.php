@extends('layouts.app')
@section('title', 'إدارة الأحداث')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-calendar-event"></i> إدارة الأحداث</h4>
    <a href="{{ route('events.create') }}" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> حدث جديد
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

{{-- إحصائيات --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px">
            <div style="font-size:26px;font-weight:800;color:#374151">{{ $stats['total'] }}</div>
            <div style="font-size:12px;color:#9ca3af">إجمالي الأحداث</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px;border-right:4px solid #d97706">
            <div style="font-size:26px;font-weight:800;color:#d97706">{{ $stats['planning'] }}</div>
            <div style="font-size:12px;color:#9ca3af">تخطيط</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px;border-right:4px solid #2563eb">
            <div style="font-size:26px;font-weight:800;color:#2563eb">{{ $stats['active'] }}</div>
            <div style="font-size:12px;color:#9ca3af">نشط</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px;border-right:4px solid #16a34a">
            <div style="font-size:26px;font-weight:800;color:#16a34a">{{ $stats['completed'] }}</div>
            <div style="font-size:12px;color:#9ca3af">مكتمل</div>
        </div>
    </div>
</div>

{{-- فلترة --}}
<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="بحث بالاسم..." value="{{ request('search') }}" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="planning"  {{ request('status')=='planning'  ? 'selected':'' }}>تخطيط</option>
                <option value="active"    {{ request('status')=='active'    ? 'selected':'' }}>نشط</option>
                <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>مكتمل</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>ملغي</option>
            </select>
        </div>
        @if($eventTypes->count())
        <div class="col-md-3">
            <select name="type" class="form-select" style="font-size:13px">
                <option value="">كل الأنواع</option>
                @foreach($eventTypes as $t)
                    <option value="{{ $t->value_ar }}" {{ request('type')==$t->value_ar ? 'selected':'' }}>{{ $t->value_ar }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="col-md-2">
            <button type="submit" class="btn btn-save w-100" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        @if(request()->hasAny(['search','status','type']))
        <div class="col-auto">
            <a href="{{ route('events.index') }}" class="btn btn-back" style="font-size:13px">مسح</a>
        </div>
        @endif
    </form>
</div>

{{-- الجدول --}}
<div class="card">
    <div class="card-body p-0">
        @if($events->count())
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>اسم الحدث</th>
                    <th>النوع</th>
                    <th>تاريخ البدء</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الموقع</th>
                    <th>المدير</th>
                    <th>الميزانية</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>
                        <div style="font-weight:600">{{ $event->name }}</div>
                        @if($event->description)
                            <div style="font-size:11px;color:#9ca3af">{{ Str::limit($event->description, 50) }}</div>
                        @endif
                    </td>
                    <td style="font-size:13px">{{ $event->type ?? '-' }}</td>
                    <td style="font-size:13px">{{ $event->start_date->format('Y-m-d') }}</td>
                    <td style="font-size:13px">{{ $event->end_date?->format('Y-m-d') ?? 'مفتوح' }}</td>
                    <td style="font-size:13px">{{ $event->location?->name ?? '-' }}</td>
                    <td style="font-size:13px">{{ $event->manager?->name ?? '-' }}</td>
                    <td style="font-size:13px">{{ $event->budget ? number_format($event->budget,0).' ر.س' : '-' }}</td>
                    <td>
                        <span style="background:{{ $event->status_bg }};color:{{ $event->status_color }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $event->status_label }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('حذف هذا الحدث؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px">{{ $events->withQueryString()->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-calendar-x" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد أحداث</p>
        </div>
        @endif
    </div>
</div>

@endsection
