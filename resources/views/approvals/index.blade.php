@extends('layouts.app')
@section('title', 'سجل الاعتمادات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-patch-check"></i> سجل الاعتمادات</h4>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($approvals->count())
        <table class="table mb-0">
            <thead>
                <tr><th>النوع</th><th>المعتمِد</th><th>الحالة</th><th>السبب / الملاحظة</th><th>التاريخ</th></tr>
            </thead>
            <tbody>
                @foreach($approvals as $appr)
                <tr>
                    <td>
                        <div style="font-size:12px;color:#6b7280">{{ class_basename($appr->model_type) }}</div>
                        <div style="font-size:11px;color:#9ca3af;font-family:monospace">#{{ $appr->model_id }}</div>
                    </td>
                    <td style="font-size:13px">{{ $appr->approver->name }}</td>
                    <td>
                        <span style="background:{{ $appr->status==='approved'?'#dcfce7':'#fee2e2' }};color:{{ $appr->status==='approved'?'#16a34a':'#dc2626' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $appr->status==='approved' ? 'معتمد' : 'مسحوب' }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6b7280">{{ Str::limit($appr->reason, 60) ?? '-' }}</td>
                    <td style="font-size:12px;color:#9ca3af">{{ $appr->approved_at?->format('Y-m-d H:i') ?? $appr->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px">{{ $approvals->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-patch-check" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد اعتمادات</p>
        </div>
        @endif
    </div>
</div>
@endsection
