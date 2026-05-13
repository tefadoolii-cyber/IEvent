<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | {{ $appSettings['platform_name_ar'] ?? 'iEvent' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: {{ $appSettings['primary_color'] ?? '#4ade80' }};
            --sidebar-color: {{ $appSettings['sidebar_color'] ?? '#1a1a2e' }};
            --background-color: {{ $appSettings['background_color'] ?? '#f4f6f9' }};
        }

        * { font-family: 'Tajawal', sans-serif; box-sizing: border-box; }
        body { background: var(--background-color); margin: 0; padding: 0; color: #1a1a2e; }

        .sidebar { width: 240px; background: var(--sidebar-color); min-height: 100vh; position: fixed; right: 0; top: 0; overflow-y: auto; z-index: 100; }
        .sidebar a, .sidebar a * { color: #9ca3af !important; text-decoration: none !important; transition: all 0.2s; }
        .sidebar .logo { padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 10px; }
        .sidebar .logo .en { color: var(--primary-color) !important; font-size: 22px; font-weight: 700; display: block; }
        .sidebar .logo .ar { color: #9ca3af !important; font-size: 12px; display: block; }
        .sidebar > a { display: flex; align-items: center; gap: 10px; padding: 10px 20px; font-size: 14px; }
        .sidebar > a:hover, .sidebar > a:hover *, .sidebar > a.active, .sidebar > a.active * { background: rgba(255,255,255,0.06); color: var(--primary-color) !important; }

        .menu-section { border-bottom: 1px solid rgba(255,255,255,0.05); }
        .menu-header { display: flex; align-items: center; justify-content: space-between; padding: 11px 20px; color: #9ca3af; cursor: pointer; font-size: 14px; transition: all 0.2s; }
        .menu-header:hover, .menu-header:hover * { background: rgba(255,255,255,0.06); color: white !important; }
        .menu-header .arrow { transition: transform 0.3s; font-size: 12px; }
        .menu-header.open .arrow { transform: rotate(180deg); }

        .menu-items { display: none; background: rgba(0,0,0,0.2); }
        .menu-items.open { display: block; }
        .menu-items a { display: flex; align-items: center; gap: 10px; padding: 9px 20px; font-size: 13px; border-right: 3px solid transparent; }
        .menu-items a:hover, .menu-items a:hover *, .menu-items a.active, .menu-items a.active * { background: rgba(255,255,255,0.06); color: var(--primary-color) !important; border-right-color: var(--primary-color); }

        .main-content { margin-right: 240px; padding: 25px; }
        .top-header { background: white; border-radius: 12px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .top-header h4 { margin: 0; font-weight: 700; font-size: 18px; }

        .card { border: none; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .card-header { background: white; border-bottom: 1px solid #f0f0f0; padding: 15px 20px; border-radius: 12px 12px 0 0 !important; display: flex; justify-content: space-between; align-items: center; }

        .table thead th { background: #f8f9fa; color: #6b7280; font-size: 13px; font-weight: 600; border: none; padding: 12px 15px; }
        .table tbody td { padding: 12px 15px; font-size: 14px; vertical-align: middle; border-color: #f0f0f0; }
        .table tbody tr:hover { background: #f9fafb; }

        .btn-add { background: var(--primary-color); color: #1a1a2e; font-weight: 600; border: none; border-radius: 8px; padding: 8px 16px; font-size: 14px; }
        .btn-add:hover { opacity: 0.9; color: #1a1a2e; }
        .btn-edit { background: #fef3c7; color: #d97706; border: none; border-radius: 6px; padding: 4px 10px; font-size: 12px; }
        .btn-delete { background: #fee2e2; color: #dc2626; border: none; border-radius: 6px; padding: 4px 10px; font-size: 12px; }
        .btn-back { background: #f3f4f6; color: #374151; border: none; border-radius: 8px; padding: 10px 20px; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-save { background: var(--primary-color); color: #1a1a2e; font-weight: 600; border: none; border-radius: 8px; padding: 10px 25px; font-size: 15px; }
        .btn-save:hover { opacity: 0.9; color: #1a1a2e; }

        .form-label { font-weight: 500; font-size: 14px; color: #374151; }
        .form-control, .form-select { border-radius: 8px; font-size: 14px; border: 1px solid #e5e7eb; padding: 10px 14px; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(74,222,128,0.1); }
        .section-title { font-size: 15px; font-weight: 700; color: #1a1a2e; border-right: 3px solid var(--primary-color); padding-right: 10px; margin-bottom: 20px; }

        .badge-active, .badge-present { background: #dcfce7; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 12px; }
        .badge-inactive, .badge-absent { background: #fee2e2; color: #dc2626; padding: 4px 10px; border-radius: 20px; font-size: 12px; }
        .badge-late { background: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu(id) {
            const menu = document.getElementById('menu-' + id);
            const arrow = document.getElementById('arrow-' + id);
            const header = arrow.closest('.menu-header');
            menu.classList.toggle('open');
            header.classList.toggle('open');
        }
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.menu-items a.active').forEach(function (link) {
                const menu = link.closest('.menu-items');
                const header = menu.previousElementSibling;
                menu.classList.add('open');
                header.classList.add('open');
            });
        });
    </script>

</body>
</html>