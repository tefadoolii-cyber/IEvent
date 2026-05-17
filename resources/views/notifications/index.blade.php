@extends('layouts.app')
@section('title', 'الإشعارات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-bell"></i> الإشعارات</h4>
    @if(Auth::user()->unreadNotifications->count())
    <form action="{{ route('notifications.read-all') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-check2-all"></i> تعليم الكل كمقروء</button>
    </form>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card">
    <div class="card-body p-0">
        @if($notifications->count())
        @foreach($notifications as $n)
        @php $data = $n->data; $isRead = !is_null($n->read_at); @endphp
        <div style="padding:16px 20px;border-bottom:1px solid #f0f0f0;background:{{ $isRead?'white':'#f0f9ff' }};display:flex;align-items:flex-start;gap:16px">
            <div style="width:40px;height:40px;background:{{ $isRead?'#f3f4f6':'#dbeafe' }};border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                @php
                    $icons = ['expiring_contract'=>'bi-file-earmark-text','late_task'=>'bi-check2-square','new_ticket'=>'bi-headset'];
                    $colors = ['expiring_contract'=>'#d97706','late_task'=>'#dc2626','new_ticket'=>'#3b82f6'];
                    $icon  = $icons[$data['type']??'']  ?? 'bi-bell';
                    $color = $colors[$data['type']??''] ?? '#6b7280';
                @endphp
                <i class="bi {{ $icon }}" style="color:{{ $color }};font-size:16px"></i>
            </div>
            <div style="flex:1">
                <div style="font-weight:{{ $isRead?'400':'700' }};font-size:14px;color:#111827">{{ $data['title'] ?? 'إشعار' }}</div>
                <div style="font-size:13px;color:#6b7280;margin-top:2px">{{ $data['message'] ?? '' }}</div>
                <div style="font-size:11px;color:#9ca3af;margin-top:4px">{{ $n->created_at->diffForHumans() }}</div>
            </div>
            <div style="display:flex;gap:6px;align-items:center">
                @if(!$isRead)
                <form action="{{ route('notifications.read', $n->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-edit" style="font-size:11px;padding:4px 8px" title="تعليم كمقروء"><i class="bi bi-check2"></i></button>
                </form>
                @endif
                @if(isset($data['url']))
                <a href="{{ $data['url'] }}" class="btn btn-save" style="font-size:11px;padding:4px 8px"><i class="bi bi-arrow-left"></i></a>
                @endif
                <form action="{{ route('notifications.destroy', $n->id) }}" method="POST" onsubmit="return confirm('حذف هذا الإشعار؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
        @endforeach
        <div style="padding:14px 20px">{{ $notifications->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-bell-slash" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد إشعارات</p>
        </div>
        @endif
    </div>
</div>
@endsection
