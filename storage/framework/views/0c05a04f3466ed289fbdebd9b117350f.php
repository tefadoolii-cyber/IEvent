<div class="sidebar">
    <div class="logo">
        <button class="sidebar-close-btn" onclick="closeSidebar()" aria-label="إغلاق القائمة">
            <i class="bi bi-x-lg"></i>
        </button>
        <?php if(!empty($appSettings['platform_logo'])): ?>
            <img src="<?php echo e(asset('storage/' . $appSettings['platform_logo'])); ?>" style="max-height: 40px; max-width: 100%; margin-bottom: 8px">
        <?php endif; ?>
        <span class="en"><?php echo e($appSettings['platform_name_en'] ?? 'HR System'); ?></span>
        <span class="ar"><?php echo e($appSettings['platform_name_ar'] ?? 'نظام الموارد البشرية'); ?></span>
    </div>

    <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
        <i class="bi bi-house"></i> الإحصائيات العامة
    </a>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('hr')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-people"></i><span>إدارة الموارد البشرية</span></div>
            <i class="bi bi-chevron-down arrow" id="arrow-hr"></i>
        </div>
        <div class="menu-items" id="menu-hr">
            <a href="<?php echo e(route('employees.index')); ?>" class="<?php echo e(request()->is('employees*') ? 'active' : ''); ?>">
                <i class="bi bi-person"></i> إدارة الموظفين
            </a>
            <a href="<?php echo e(route('attendance.index')); ?>" class="<?php echo e(request()->is('attendance*') ? 'active' : ''); ?>">
                <i class="bi bi-calendar-check"></i> الحضور والانصراف
            </a>
            <a href="<?php echo e(route('contracts.index')); ?>" class="<?php echo e(request()->is('contracts*') ? 'active' : ''); ?>">
                <i class="bi bi-file-earmark-text"></i> إدارة العقود
            </a>
            <a href="<?php echo e(route('tasks.index')); ?>" class="<?php echo e(request()->is('tasks*') ? 'active' : ''); ?>">
                <i class="bi bi-check2-square"></i> إدارة المهام
            </a>
            <a href="<?php echo e(route('assets.index')); ?>" class="<?php echo e(request()->is('assets*') ? 'active' : ''); ?>">
                <i class="bi bi-laptop"></i> إدارة العهد
            </a>
            <a href="<?php echo e(route('job-applications.index')); ?>" class="<?php echo e(request()->is('job-applications*') ? 'active' : ''); ?>">
                <i class="bi bi-people"></i> المتقدمون للوظائف
            </a>
        </div>
    </div>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('events')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-calendar-event"></i><span>الأحداث</span></div>
            <i class="bi bi-chevron-down arrow" id="arrow-events"></i>
        </div>
        <div class="menu-items" id="menu-events">
            <a href="<?php echo e(route('events.index')); ?>" class="<?php echo e(request()->is('events*') ? 'active' : ''); ?>">
                <i class="bi bi-calendar-event"></i> إدارة الأحداث
            </a>
        </div>
    </div>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('ops')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-tools"></i><span>إدارة التشغيل</span></div>
            <i class="bi bi-chevron-down arrow" id="arrow-ops"></i>
        </div>
        <div class="menu-items" id="menu-ops">
            <a href="<?php echo e(route('assignments.index')); ?>" class="<?php echo e(request()->is('assignments*') ? 'active' : ''); ?>">
                <i class="bi bi-person-check"></i> إدارة الإسنادات
            </a>
            <a href="<?php echo e(route('teams.index')); ?>" class="<?php echo e(request()->is('teams*') ? 'active' : ''); ?>">
                <i class="bi bi-people-fill"></i> الفرق الميدانية
            </a>
            <a href="<?php echo e(route('regions.index')); ?>" class="<?php echo e(request()->is('regions*') ? 'active' : ''); ?>">
                <i class="bi bi-map"></i> المناطق
            </a>
            <a href="<?php echo e(route('shifts.index')); ?>" class="<?php echo e(request()->is('shifts*') ? 'active' : ''); ?>">
                <i class="bi bi-clock"></i> الورديات
            </a>
            <a href="<?php echo e(route('visits.index')); ?>" class="<?php echo e(request()->is('visits*') ? 'active' : ''); ?>">
                <i class="bi bi-geo-alt-fill"></i> الزيارات
            </a>
            <a href="<?php echo e(route('locations.index')); ?>" class="<?php echo e(request()->is('locations*') ? 'active' : ''); ?>">
                <i class="bi bi-geo-alt"></i> إدارة المواقع
            </a>
            <a href="<?php echo e(route('companies.index')); ?>" class="<?php echo e(request()->is('companies*') ? 'active' : ''); ?>">
                <i class="bi bi-building"></i> إدارة الشركات
            </a>
        </div>
    </div>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('data')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-database"></i><span>البيانات والباقات</span></div>
            <i class="bi bi-chevron-down arrow" id="arrow-data"></i>
        </div>
        <div class="menu-items" id="menu-data">
            <a href="<?php echo e(route('packages.index')); ?>" class="<?php echo e(request()->is('packages*') ? 'active' : ''); ?>">
                <i class="bi bi-box-seam"></i> الباقات
            </a>
            <a href="<?php echo e(route('surveys.index')); ?>" class="<?php echo e(request()->is('surveys*') ? 'active' : ''); ?>">
                <i class="bi bi-clipboard-data"></i> الاستبيانات
            </a>
            <a href="<?php echo e(route('imports.index')); ?>" class="<?php echo e(request()->is('imports*') ? 'active' : ''); ?>">
                <i class="bi bi-file-earmark-arrow-up"></i> استيراد البيانات
            </a>
        </div>
    </div>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('quality')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-award"></i><span>الجودة والتقييم</span></div>
            <i class="bi bi-chevron-down arrow" id="arrow-quality"></i>
        </div>
        <div class="menu-items" id="menu-quality">
            <a href="<?php echo e(route('evaluations.index')); ?>" class="<?php echo e(request()->is('evaluations*') ? 'active' : ''); ?>">
                <i class="bi bi-star-half"></i> التقييمات
            </a>
            <a href="<?php echo e(route('readiness-licenses.index')); ?>" class="<?php echo e(request()->is('readiness-licenses*') ? 'active' : ''); ?>">
                <i class="bi bi-shield-check"></i> رخص الجاهزية
            </a>
            <a href="<?php echo e(route('approvals.index')); ?>" class="<?php echo e(request()->is('approvals*') ? 'active' : ''); ?>">
                <i class="bi bi-patch-check"></i> الاعتمادات
            </a>
            <a href="<?php echo e(route('notes.index')); ?>" class="<?php echo e(request()->is('notes*') ? 'active' : ''); ?>">
                <i class="bi bi-chat-square-text"></i> الملاحظات
            </a>
        </div>
    </div>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('support')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-headset"></i><span>الدعم الفني</span></div>
            <i class="bi bi-chevron-down arrow" id="arrow-support"></i>
        </div>
        <div class="menu-items" id="menu-support">
            <a href="<?php echo e(route('support-tickets.index')); ?>" class="<?php echo e(request()->is('support-tickets*') ? 'active' : ''); ?>">
                <i class="bi bi-ticket"></i> تذاكر الدعم
            </a>
        </div>
    </div>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('reports')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-bar-chart-line"></i><span>التقارير</span></div>
            <i class="bi bi-chevron-down arrow" id="arrow-reports"></i>
        </div>
        <div class="menu-items" id="menu-reports">
            <a href="<?php echo e(route('reports.index')); ?>" class="<?php echo e(request()->is('reports') ? 'active' : ''); ?>">
                <i class="bi bi-grid-1x2"></i> مركز التقارير
            </a>
            <a href="<?php echo e(route('reports.attendance')); ?>" class="<?php echo e(request()->is('reports/attendance*') ? 'active' : ''); ?>">
                <i class="bi bi-calendar-check"></i> تقرير الحضور
            </a>
            <a href="<?php echo e(route('reports.contracts')); ?>" class="<?php echo e(request()->is('reports/contracts*') ? 'active' : ''); ?>">
                <i class="bi bi-file-earmark-text"></i> تقرير العقود
            </a>
            <a href="<?php echo e(route('reports.evaluations')); ?>" class="<?php echo e(request()->is('reports/evaluations*') ? 'active' : ''); ?>">
                <i class="bi bi-star-half"></i> تقرير التقييمات
            </a>
            <a href="<?php echo e(route('reports.tasks')); ?>" class="<?php echo e(request()->is('reports/tasks*') ? 'active' : ''); ?>">
                <i class="bi bi-check2-square"></i> تقرير المهام
            </a>
        </div>
    </div>

    
    <div class="menu-section">
        <div class="menu-header" onclick="toggleMenu('it')">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-gear"></i><span>إدارة تقنية المعلومات</span></div>
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
                <i class="bi bi-grid-3x3-gap"></i> إدارة الوحدات
            </a>
            <a href="<?php echo e(route('settings.index')); ?>" class="<?php echo e(request()->is('settings*') ? 'active' : ''); ?>">
                <i class="bi bi-gear"></i> إعدادات النظام
            </a>
            <a href="<?php echo e(route('custom-fields.index')); ?>" class="<?php echo e(request()->is('custom-fields*') ? 'active' : ''); ?>">
                <i class="bi bi-input-cursor-text"></i> الحقول المخصصة
            </a>
            <a href="<?php echo e(route('lookup-groups.index')); ?>" class="<?php echo e(request()->is('lookup-groups*') ? 'active' : ''); ?>">
                <i class="bi bi-list-ul"></i> التعريفات الاستعلامية
            </a>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('logout')); ?>" style="padding: 15px 20px; border-top: 1px solid #2d2d4e; margin-top: 10px;">
        <?php echo csrf_field(); ?>
        <button type="submit" style="background: transparent; border: 1px solid #dc2626; color: #dc2626; width: 100%; padding: 10px; border-radius: 8px; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
        </button>
    </form>
</div>
<?php /**PATH D:\course laravel\example-app\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>