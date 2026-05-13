<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | بوابة الموظف</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Tajawal', sans-serif; box-sizing: border-box; }
        body { background: #f4f6f9; margin: 0; }

        .navbar { background: linear-gradient(135deg, #1a1a2e 0%, #2d2d4e 100%); padding: 12px 30px; color: white; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .navbar .brand { display: flex; align-items: center; gap: 12px; font-size: 18px; font-weight: 700; }
        .navbar .brand i { color: #d4af37; font-size: 24px; }
        .navbar .nav-links { display: flex; gap: 25px; }
        .navbar .nav-links a { color: #d1d5db; text-decoration: none; font-size: 14px; transition: 0.2s; }
        .navbar .nav-links a:hover, .navbar .nav-links a.active { color: #d4af37; }
        .navbar .user-info { display: flex; align-items: center; gap: 12px; }
        .navbar .user-info .name { font-size: 14px; }
        .navbar .logout-btn { background: transparent; border: 1px solid #dc2626; color: #fca5a5; padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }

        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }

        .card { background: white; border-radius: 14px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; border: none; }

        .btn-action { background: linear-gradient(135deg, #d4af37 0%, #c19b2c 100%); color: #1a1a2e; font-weight: 700; border: none; border-radius: 10px; padding: 14px 30px; font-size: 16px; cursor: pointer; box-shadow: 0 4px 12px rgba(212,175,55,0.3); transition: 0.2s; }
        .btn-action:hover { transform: translateY(-1px); }
        .btn-checkout { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }

        .stat-card { background: white; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .stat-card .icon { font-size: 30px; margin-bottom: 8px; }
        .stat-card .num { font-size: 28px; font-weight: 800; color: #1a1a2e; }
        .stat-card .label { color: #6b7280; font-size: 13px; }

        .welcome { background: linear-gradient(135deg, #1a1a2e 0%, #2d2d4e 100%); color: white; padding: 30px; border-radius: 14px; margin-bottom: 25px; }
        .welcome h2 { margin: 0 0 8px; font-weight: 700; }
        .welcome p { margin: 0; color: #9ca3af; }

        .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
        .info-row:last-child { border-bottom: none; }
        .info-row .label { color: #6b7280; font-size: 14px; }
        .info-row .value { font-weight: 600; font-size: 14px; }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="brand">
            <i class="bi bi-calendar2-event"></i>
            <span>بوابة الموظف</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('portal.dashboard') }}" class="{{ request()->routeIs('portal.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house"></i> الرئيسية
            </a>
            <a href="{{ route('portal.profile') }}" class="{{ request()->routeIs('portal.profile') ? 'active' : '' }}">
                <i class="bi bi-person"></i> بياناتي
            </a>
        </div>
        <div class="user-info">
            <span class="name">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> خروج
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>