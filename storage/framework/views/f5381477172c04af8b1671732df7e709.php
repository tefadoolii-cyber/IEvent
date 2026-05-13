<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول | <?php echo e($appSettings['platform_name_ar'] ?? 'iEvent'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { margin: 0; padding: 0; min-height: 100vh; background: #fff; }
        .container-fluid { padding: 0; }
        .login-wrapper { min-height: 100vh; display: flex; }

        /* الصورة على اليسار */
        .login-image {
            flex: 1;
            background: linear-gradient(135deg, #1a1a2e 0%, #2d2d4e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .login-image::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.1);
            top: -200px;
            right: -200px;
        }
        .login-image::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.08);
            bottom: -100px;
            left: -100px;
        }
        .image-content {
            text-align: center;
            color: white;
            padding: 40px;
            position: relative;
            z-index: 1;
        }
        .image-content i {
            font-size: 120px;
            color: #d4af37;
            margin-bottom: 30px;
        }
        .image-content h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .image-content p {
            font-size: 16px;
            color: #9ca3af;
            line-height: 1.8;
        }

        /* فورم تسجيل الدخول */
        .login-form-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: white;
        }
        .login-form {
            width: 100%;
            max-width: 420px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-logo img {
            max-height: 80px;
            margin-bottom: 15px;
        }
        .login-logo .name {
            font-size: 28px;
            font-weight: 900;
            color: #1a1a2e;
        }
        .login-logo .sub {
            color: #9ca3af;
            font-size: 14px;
            margin-top: 5px;
        }
        .welcome-text {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome-text h3 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .welcome-text p {
            color: #6b7280;
            font-size: 14px;
        }
        .form-label {
            font-weight: 500;
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #d4af37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }
        .input-group {
            position: relative;
        }
        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 16px;
            color: #9ca3af;
            z-index: 10;
        }
        .input-group .form-control {
            padding-left: 45px;
        }
        .btn-login {
            background: linear-gradient(135deg, #d4af37 0%, #c19b2c 100%);
            color: #1a1a2e;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            padding: 14px;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #c19b2c 0%, #a08524 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(212, 175, 55, 0.35);
        }
        .form-check-input:checked {
            background-color: #d4af37;
            border-color: #d4af37;
        }
        .forgot-link {
            color: #d4af37;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        .forgot-link:hover {
            color: #c19b2c;
            text-decoration: underline;
        }
        .alert {
            border-radius: 10px;
            font-size: 14px;
            padding: 12px 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-image { display: none; }
            .login-form-wrapper { flex: 1; padding: 20px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- الصورة على اليسار -->
    <div class="login-image">
        <div class="image-content">
            <i class="bi bi-calendar2-event"></i>
            <h2><?php echo e($appSettings['platform_name_ar'] ?? 'نظام الفعاليات'); ?></h2>
            <p>منصة متكاملة لإدارة الفعاليات والعمليات الميدانية بكفاءة عالية</p>
        </div>
    </div>

    <!-- فورم تسجيل الدخول -->
    <div class="login-form-wrapper">
        <div class="login-form">
            <!-- الشعار -->
            <div class="login-logo">
                <?php if(!empty($appSettings['platform_logo'])): ?>
                    <img src="<?php echo e(asset('storage/' . $appSettings['platform_logo'])); ?>" alt="Logo">
                <?php endif; ?>
                <div class="name"><?php echo e($appSettings['platform_name_en'] ?? 'iEvent'); ?></div>
                <div class="sub"><?php echo e($appSettings['platform_name_ar'] ?? 'نظام الفعاليات'); ?></div>
            </div>

            <!-- ترحيب -->
            <div class="welcome-text">
                <h3>أهلاً بعودتك 👋</h3>
                <p>سجّل دخولك للوصول إلى لوحة التحكم</p>
            </div>

            <!-- رسائل الخطأ -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <!-- الفورم -->
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <div class="input-group">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" class="form-control" placeholder="example@email.com" value="<?php echo e(old('email')); ?>" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-group">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember" style="font-size:13px; color:#6b7280">تذكرني</label>
                    </div>
                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">نسيت كلمة المرور؟</a>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    تسجيل الدخول
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html><?php /**PATH D:\course laravel\example-app\resources\views/auth/login.blade.php ENDPATH**/ ?>