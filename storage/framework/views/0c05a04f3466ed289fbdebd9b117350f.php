<div class="sidebar">
    <div class="logo">
        <?php if(!empty($appSettings['platform_logo'])): ?>
            <img src="<?php echo e(asset('storage/' . $appSettings['platform_logo'])); ?>" style="max-height: 40px; max-width: 100%; margin-bottom: 8px">
        <?php endif; ?>
        <span class="en"><?php echo e($appSettings['platform_name_en'] ?? 'iEvent'); ?></span>
        <span class="ar"><?php echo e($appSettings['platform_name_ar'] ?? 'نظام الفعاليات'); ?></span>
    </div>

    <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
        <i class="bi bi-house"></i> الإحصائيات العامة
    </a>

    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('hr')">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-people"></i>
                <span>إدارة الموارد البشرية</span>
            </div>
            <i class="bi bi-chevron-down arrow" id="arrow-hr"></i>
        </div>
        <div class="menu-items" id="menu-hr">
            <a href="<?php echo e(route('employees.index')); ?>" class="<?php echo e(request()->is('employees*') ? 'active' : ''); ?>">
                <i class="bi bi-person"></i> إدارة الموظفين
            </a>
            <a href="<?php echo e(route('attendance.index')); ?>" class="<?php echo e(request()->is('attendance*') ? 'active' : ''); ?>">
                <i class="bi bi-calendar-check"></i> الحضور والانصراف
            </a>
        </div>
    </div>

    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('data')">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-database"></i>
                <span>إدارة البيانات</span>
            </div>
            <i class="bi bi-chevron-down arrow" id="arrow-data"></i>
        </div>
        <div class="menu-items" id="menu-data">
            <a href="#"><i class="bi bi-building"></i> إدارة الشركات</a>
            <a href="#"><i class="bi bi-box"></i> إدارة الباقات</a>
            <a href="#"><i class="bi bi-geo-alt"></i> إدارة المواقع</a>
            <a href="#"><i class="bi bi-clipboard"></i> إدارة الاستبيانات</a>
            <a href="#"><i class="bi bi-upload"></i> استيراد البيانات</a>
        </div>
    </div>

    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('ops')">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-tools"></i>
                <span>إدارة التشغيل</span>
            </div>
            <i class="bi bi-chevron-down arrow" id="arrow-ops"></i>
        </div>
        <div class="menu-items" id="menu-ops">
            <a href="#"><i class="bi bi-people"></i> إدارة الفرق الميدانية</a>
            <a href="#"><i class="bi bi-person-check"></i> إدارة الإسنادات</a>
            <a href="#"><i class="bi bi-car-front"></i> إدارة الزيارات</a>
            <a href="#"><i class="bi bi-bell"></i> إدارة التنبيهات</a>
            <a href="#"><i class="bi bi-clock"></i> إدارة الورديات</a>
            <a href="#"><i class="bi bi-map"></i> إدارة المناطق</a>
        </div>
    </div>

    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('quality')">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-shield-check"></i>
                <span>إدارة الجودة</span>
            </div>
            <i class="bi bi-chevron-down arrow" id="arrow-quality"></i>
        </div>
        <div class="menu-items" id="menu-quality">
            <a href="#"><i class="bi bi-star"></i> إدارة التقييمات</a>
            <a href="#"><i class="bi bi-patch-check"></i> رخصة الجاهزية</a>
            <a href="#"><i class="bi bi-file-check"></i> تقارير المخيمات</a>
            <a href="#"><i class="bi bi-chat-left-text"></i> الملاحظات</a>
            <a href="#"><i class="bi bi-tags"></i> أنواع الملاحظات</a>
        </div>
    </div>

    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('it')">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-gear"></i>
                <span>إدارة تقنية المعلومات</span>
            </div>
            <i class="bi bi-chevron-down arrow" id="arrow-it"></i>
        </div>
        <div class="menu-items" id="menu-it">
            <a href="<?php echo e(route('users.index')); ?>" class="<?php echo e(request()->is('users*') ? 'active' : ''); ?>">
                <i class="bi bi-person-gear"></i> إدارة المستخدمين
            </a>
            <a href="<?php echo e(route('roles.index')); ?>" class="<?php echo e(request()->is('roles*') ? 'active' : ''); ?>">
                <i class="bi bi-shield-lock"></i> الأدوار والصلاحيات
            </a>
            <a href="<?php echo e(route('modules.index')); ?>" class="<?php echo e(request()->is('modules*') ? 'active' : ''); ?>">
                <i class="bi bi-grid-3x3-gap"></i> إدارة الإدارات
            </a>
            <a href="<?php echo e(route('settings.index')); ?>" class="<?php echo e(request()->is('settings*') ? 'active' : ''); ?>">
                <i class="bi bi-gear"></i> إعدادات النظام
            </a>
            <a href="<?php echo e(route('custom-fields.index')); ?>" class="<?php echo e(request()->is('custom-fields*') ? 'active' : ''); ?>">
                <i class="bi bi-input-cursor-text"></i> الحقول المخصصة
            </a>
            <a href="<?php echo e(route('lookup-groups.index')); ?>" class="<?php echo e(request()->is('lookup-groups*') ? 'active' : ''); ?>">
                <i class="bi bi-list-ul"></i> التعريفات الإستعلامية
            </a>
            <a href="#"><i class="bi bi-plug"></i> إدارة التكاملات</a>
        </div>
    </div>

    <a href="#">
        <i class="bi bi-headset"></i> الدعم الفني
    </a>

    <form method="POST" action="<?php echo e(route('logout')); ?>" style="padding: 15px 20px; border-top: 1px solid #2d2d4e; margin-top: 10px;">
        <?php echo csrf_field(); ?>
        <button type="submit" style="background: transparent; border: 1px solid #dc2626; color: #dc2626; width: 100%; padding: 10px; border-radius: 8px; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="bi bi-box-arrow-right"></i>
            تسجيل الخروج
        </button>
    </form>
</div><?php /**PATH D:\course laravel\example-app\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>