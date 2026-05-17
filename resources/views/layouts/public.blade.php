<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'التقديم على وظيفة')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Tajawal', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            margin: 0;
        }
        .pub-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .pub-header .logo-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .pub-header h1 {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 4px;
        }
        .pub-header p {
            font-size: 13px;
            opacity: 0.7;
            margin: 0;
        }
        .pub-main {
            padding: 30px 0 50px;
        }
        .pub-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a2e;
            padding-bottom: 10px;
            margin-bottom: 18px;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title i {
            color: #0f3460;
            font-size: 17px;
        }
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-family: 'Tajawal', sans-serif;
            font-size: 14px;
            padding: 10px 14px;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0f3460;
            box-shadow: 0 0 0 3px rgba(15,52,96,0.1);
        }
        .btn-submit {
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 40px;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15,52,96,0.35);
        }
        .pub-footer {
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
            padding: 20px 0;
        }
        .alert {
            border-radius: 10px;
            font-size: 13px;
        }
        .required-star { color: #dc2626; }
        @media (max-width: 768px) {
            .pub-card { padding: 20px 16px; }
            .pub-header { padding: 16px 0; }
            .pub-header .logo-icon { width: 48px; height: 48px; font-size: 22px; }
            .pub-header h1 { font-size: 18px; }
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="pub-header">
    <div class="container">
        <div class="logo-icon"><i class="bi bi-building-fill-gear"></i></div>
        <h1>نظام إدارة الموارد البشرية</h1>
        <p>@yield('header-subtitle', 'بوابة التوظيف الإلكترونية')</p>
    </div>
</div>

<div class="pub-main">
    <div class="container">
        @yield('content')
    </div>
</div>

<div class="pub-footer">
    <div class="container">
        <p>جميع الحقوق محفوظة &copy; {{ date('Y') }}</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
