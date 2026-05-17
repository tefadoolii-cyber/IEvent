@extends('layouts.app')
@section('title', 'تفاصيل الفريق')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-people-fill"></i> {{ $team->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('teams.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-info-circle"></i> معلومات الفريق</span></div>
            <div class="card-body" style="padding:20px">
                @foreach([
                    ['icon'=>'bi-people',    'label'=>'اسم الفريق',  'value'=>$team->name],
                    ['icon'=>'bi-person-check','label'=>'المشرف',     'value'=>$team->supervisor?->name],
                    ['icon'=>'bi-map',       'label'=>'المنطقة',      'value'=>$team->region?->name],
                    ['icon'=>'bi-person-badge','label'=>'عدد الأعضاء','value'=>$team->members->count().' موظف'],
                ] as $row)
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi {{ $row['icon'] }}" style="color:#9ca3af;width:16px;flex-shrink:0"></i>
                    <span style="color:#6b7280;flex:1">{{ $row['label'] }}</span>
                    <span style="font-weight:600">{{ $row['value'] ?? '-' }}</span>
                </div>
                @endforeach
                @if($team->notes)
                <div style="margin-top:12px;padding:10px;background:#f9fafb;border-radius:8px;font-size:13px;color:#374151">{{ $team->notes }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-person-lines-fill"></i> أعضاء الفريق</span></div>
            <div class="card-body" style="padding:16px">
                @if($allEmployees->count())
                <form action="{{ route('teams.members.add', $team->id) }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-8">
                        <select name="employee_id" class="form-select" style="font-size:13px" required>
                            <option value="">-- اختر موظفاً --</option>
                            @foreach($allEmployees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }} — {{ $emp->employee_number }} — {{ $emp->department ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-save w-100" style="font-size:13px"><i class="bi bi-plus"></i> إضافة عضو</button>
                    </div>
                </form>
                @endif

                @if($team->members->count())
                <table class="table mb-0">
                    <thead><tr><th>الموظف</th><th>رقم الهوية</th><th>القسم</th><th>المسمى</th><th></th></tr></thead>
                    <tbody>
                        @foreach($team->members as $emp)
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
                            <td style="font-size:13px">{{ $emp->position ?? '-' }}</td>
                            <td>
                                <form action="{{ route('teams.members.remove', [$team->id, $emp->id]) }}" method="POST" onsubmit="return confirm('إزالة العضو؟')">
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
                    <p class="mt-2 mb-0" style="font-size:13px">لا يوجد أعضاء في الفريق</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
