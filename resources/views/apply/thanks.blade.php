@extends('layouts.public')

@section('title', 'تم إرسال طلبك')
@section('header-subtitle', 'بوابة التوظيف الإلكترونية')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="pub-card" style="text-align:center;padding:50px 32px">
            <div style="width:90px;height:90px;background:linear-gradient(135deg,#16a34a,#15803d);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:24px;box-shadow:0 8px 24px rgba(22,163,74,0.3)">
                <i class="bi bi-check-lg" style="color:white;font-size:44px"></i>
            </div>

            <h2 style="font-size:24px;font-weight:800;color:#1a1a2e;margin-bottom:10px">تم إرسال طلبك بنجاح!</h2>
            <p style="color:#6b7280;font-size:15px;line-height:1.7;margin-bottom:28px">
                شكراً لتقديمك. تم استلام طلب التوظيف الخاص بك وسيتم مراجعته من قِبل فريق الموارد البشرية.
                سيتم التواصل معك في حال مطابقة متطلبات الوظيفة.
            </p>

            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px 20px;margin-bottom:28px;text-align:right">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                    <i class="bi bi-clock" style="color:#16a34a;font-size:15px"></i>
                    <span style="font-weight:700;font-size:14px;color:#15803d">ما يمكن توقعه:</span>
                </div>
                <ul style="color:#374151;font-size:13px;line-height:2;padding-right:20px;margin:0">
                    <li>مراجعة طلبك خلال 3-5 أيام عمل</li>
                    <li>التواصل معك عبر الجوال أو البريد الإلكتروني</li>
                    <li>دعوتك لمقابلة في حال اجتياز مرحلة الفحص الأولي</li>
                </ul>
            </div>

            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                <a href="{{ route('apply') }}" style="display:inline-flex;align-items:center;gap:8px;background:#1a1a2e;color:white;padding:12px 24px;border-radius:10px;font-weight:600;font-size:14px;text-decoration:none;transition:all 0.2s">
                    <i class="bi bi-plus-circle"></i> تقديم طلب آخر
                </a>
                <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:8px;background:#f3f4f6;color:#374151;padding:12px 24px;border-radius:10px;font-weight:600;font-size:14px;text-decoration:none;transition:all 0.2s">
                    <i class="bi bi-box-arrow-in-right"></i> تسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
