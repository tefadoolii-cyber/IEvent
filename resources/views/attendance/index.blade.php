@extends('layouts.app')

@section('title', 'إدارة الحضور والانصراف')

@section('content')

<div class="top-header">
    <h4>إدارة الحضور والانصراف</h4>
    <a href="{{ route('attendance.create') }}" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> تسجيل حضور
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#16a34a">{{ $attendance->where('status', 'present')->count() }}</div>
            <div style="color:#6b7280; font-size:13px">حاضر اليوم</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#dc2626">{{ $attendance->where('status', 'absent')->count() }}</div>
            <div style="color:#6b7280; font-size:13px">غائب</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#d97706">{{ $attendance->where('status', 'late')->count() }}</div>
            <div style="color:#6b7280; font-size:13px">متأخر</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#1a1a2e">{{ $attendance->total() }}</div>
            <div style="color:#6b7280; font-size:13px">إجمالي السجلات</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">سجلات الحضور</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الموظف</th>
                    <th>التاريخ</th>
                    <th>الحضور</th>
                    <th>الانصراف</th>
                    <th>الحالة</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendance as $record)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div style="font-weight:600">{{ $record->employee->name ?? '-' }}</div>
                        <div style="color:#9ca3af; font-size:12px">{{ $record->employee->employee_number ?? '' }}</div>
                    </td>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->check_in ?? '-' }}</td>
                    <td>{{ $record->check_out ?? '-' }}</td>
                    <td>
                        @if($record->status == 'present')
                            <span class="badge-active">حاضر</span>
                        @elseif($record->status == 'absent')
                            <span class="badge-inactive">غائب</span>
                        @else
                            <span class="badge-late">متأخر</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('attendance.edit', $record->id) }}" class="btn btn-edit">تعديل</a>
                        <form action="{{ route('attendance.destroy', $record->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4" style="color:#9ca3af">لا يوجد سجلات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $attendance->links() }}</div>

@endsection