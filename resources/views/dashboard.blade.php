@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')

<div class="top-header">
    <h4>الرئيسية</h4>
</div>

<div class="card">
    <div class="card-body" style="padding:30px">
        <h5>مرحباً بك، {{ Auth::user()->name }} 👋</h5>
        <p style="color:#6b7280">أنت مسجل الدخول إلى منصة iEvent</p>
    </div>
</div>

@endsection