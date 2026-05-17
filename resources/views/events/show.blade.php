@extends('layouts.app')
@section('title', 'تفاصيل الحدث')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-calendar-event"></i> {{ $event->name }}</h4>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('events.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">
    {{-- بطاقة الحدث --}}
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-info-circle"></i> معلومات الحدث</span></div>
            <div class="card-body" style="padding:20px">
                <div style="text-align:center;margin-bottom:18px">
                    <div style="width:70px;height:70px;background:linear-gradient(135deg,#1a1a2e,#0f3460);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px">
                        <i class="bi bi-calendar-event" style="color:white;font-size:30px"></i>
                    </div>
                    <div style="font-weight:800;font-size:17px;color:#1a1a2e">{{ $event->name }}</div>
                    <div style="margin-top:8px">
                        <span style="background:{{ $event->status_bg }};color:{{ $event->status_color }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">
                            {{ $event->status_label }}
                        </span>
                    </div>
                </div>

                @foreach([
                    ['icon'=>'bi-tag',       'label'=>'النوع',         'value'=>$event->type],
                    ['icon'=>'bi-calendar',  'label'=>'تاريخ البدء',  'value'=>$event->start_date->format('Y-m-d')],
                    ['icon'=>'bi-calendar-x','label'=>'تاريخ الانتهاء','value'=>$event->end_date?->format('Y-m-d') ?? 'مفتوح'],
                    ['icon'=>'bi-clock',     'label'=>'المدة',         'value'=>$stats['duration'].' يوم'],
                    ['icon'=>'bi-geo-alt',   'label'=>'الموقع',        'value'=>$event->location?->name],
                    ['icon'=>'bi-person',    'label'=>'المدير',        'value'=>$event->manager?->name],
                    ['icon'=>'bi-cash',      'label'=>'الميزانية',     'value'=>$event->budget ? number_format($event->budget,0).' ر.س' : null],
                    ['icon'=>'bi-people',    'label'=>'الموظفون',      'value'=>$stats['employees'].' موظف'],
                ] as $row)
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi {{ $row['icon'] }}" style="color:#9ca3af;width:16px;flex-shrink:0"></i>
                    <span style="color:#6b7280;flex:1">{{ $row['label'] }}</span>
                    <span style="font-weight:600">{{ $row['value'] ?? '-' }}</span>
                </div>
                @endforeach
            </div>
        </div>

        @if($event->description)
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-text-left"></i> الوصف</span></div>
            <div class="card-body" style="padding:16px;font-size:13px;line-height:1.7;color:#374151">{{ $event->description }}</div>
        </div>
        @endif
    </div>

    <div class="col-md-8">
        {{-- الموظفون المشاركون --}}
        <div class="card mb-3">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-people"></i> الموظفون المشاركون ({{ $event->employees->count() }})</span>
            </div>
            <div class="card-body" style="padding:16px">
                {{-- إضافة موظف --}}
                @if($allEmployees->count())
                <form action="{{ route('events.employees.add', $event->id) }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-6">
                        <select name="employee_id" class="form-select" style="font-size:13px" required>
                            <option value="">-- اختر موظف --</option>
                            @foreach($allEmployees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }} — {{ $emp->employee_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="role" class="form-control" placeholder="الدور في الحدث" style="font-size:13px">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-save w-100" style="font-size:13px"><i class="bi bi-plus"></i> إضافة</button>
                    </div>
                </form>
                @endif

                @if($event->employees->count())
                <table class="table mb-0">
                    <thead>
                        <tr><th>الموظف</th><th>رقم الهوية</th><th>القسم</th><th>الدور</th><th></th></tr>
                    </thead>
                    <tbody>
                        @foreach($event->employees as $emp)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div style="width:32px;height:32px;border-radius:50%;background:#1a1a2e;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0">
                                        @if($emp->photo)
                                            <img src="{{ Storage::disk('public')->url($emp->photo) }}" style="width:32px;height:32px;object-fit:cover">
                                        @else
                                            <span style="color:white;font-size:12px;font-weight:700">{{ mb_substr($emp->name,0,1) }}</span>
                                        @endif
                                    </div>
                                    <span style="font-weight:600;font-size:13px">{{ $emp->name }}</span>
                                </div>
                            </td>
                            <td style="font-size:12px;font-family:monospace">{{ $emp->employee_number }}</td>
                            <td style="font-size:13px">{{ $emp->department ?? '-' }}</td>
                            <td style="font-size:13px">{{ $emp->pivot->role ?? '-' }}</td>
                            <td>
                                <form action="{{ route('events.employees.remove', [$event->id, $emp->id]) }}" method="POST" onsubmit="return confirm('إزالة الموظف من الحدث؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete" style="font-size:11px;padding:3px 8px"><i class="bi bi-x-lg"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-4" style="color:#9ca3af">
                    <i class="bi bi-people" style="font-size:24px"></i>
                    <p class="mt-2 mb-0" style="font-size:13px">لا يوجد موظفون مضافون للحدث</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
