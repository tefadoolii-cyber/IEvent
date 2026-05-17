@extends('layouts.app')
@section('title', 'تفاصيل الوردية')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-clock"></i> {{ $shift->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('shifts.edit', $shift->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('shifts.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-info-circle"></i> معلومات الوردية</span></div>
            <div class="card-body" style="padding:20px">
                @foreach([
                    ['icon'=>'bi-clock',    'label'=>'وقت البدء',    'value'=>$shift->start_time],
                    ['icon'=>'bi-clock-history','label'=>'وقت الانتهاء','value'=>$shift->end_time],
                    ['icon'=>'bi-calendar', 'label'=>'الأيام',        'value'=>$shift->days_label],
                    ['icon'=>'bi-people',   'label'=>'الموظفون',      'value'=>$shift->employees->count().' موظف'],
                ] as $row)
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi {{ $row['icon'] }}" style="color:#9ca3af;width:16px;flex-shrink:0"></i>
                    <span style="color:#6b7280;flex:1">{{ $row['label'] }}</span>
                    <span style="font-weight:600">{{ $row['value'] ?? '-' }}</span>
                </div>
                @endforeach
                @if($shift->notes)
                <div style="margin-top:12px;padding:10px;background:#f9fafb;border-radius:8px;font-size:13px;color:#374151">{{ $shift->notes }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-person-badge"></i> الموظفون المعينون</span></div>
            <div class="card-body" style="padding:16px">
                @if($allEmployees->count())
                <form action="{{ route('shifts.employees.add', $shift->id) }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-5">
                        <select name="employee_id" class="form-select" style="font-size:13px" required>
                            <option value="">-- اختر موظفاً --</option>
                            @foreach($allEmployees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }} — {{ $emp->employee_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="effective_date" class="form-control" style="font-size:13px" placeholder="تاريخ التطبيق">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-save w-100" style="font-size:13px"><i class="bi bi-plus"></i> تعيين</button>
                    </div>
                </form>
                @endif

                @if($shift->employees->count())
                <table class="table mb-0">
                    <thead><tr><th>الموظف</th><th>رقم الهوية</th><th>القسم</th><th>تاريخ التطبيق</th><th></th></tr></thead>
                    <tbody>
                        @foreach($shift->employees as $emp)
                        <tr>
                            <td style="font-weight:600;font-size:13px">{{ $emp->name }}</td>
                            <td style="font-size:12px;font-family:monospace">{{ $emp->employee_number }}</td>
                            <td style="font-size:13px">{{ $emp->department ?? '-' }}</td>
                            <td style="font-size:12px">{{ $emp->pivot->effective_date ?? '-' }}</td>
                            <td>
                                <form action="{{ route('shifts.employees.remove', [$shift->id, $emp->id]) }}" method="POST" onsubmit="return confirm('إزالة الموظف من الوردية؟')">
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
                    <i class="bi bi-person-x" style="font-size:24px"></i>
                    <p class="mt-2 mb-0" style="font-size:13px">لم يُعيَّن موظفون لهذه الوردية</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
