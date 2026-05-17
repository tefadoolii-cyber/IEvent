<?php $__env->startSection('title', 'التقارير'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-bar-chart-line"></i> مركز التقارير</h4>
</div>

<div class="row g-4">
    <?php $__currentLoopData = [
        [
            'title'   => 'تقرير الحضور الشهري',
            'desc'    => 'ملخص الحضور والغياب والتأخر لجميع الموظفين مع إمكانية التصدير إلى Excel',
            'icon'    => 'bi-calendar-check',
            'color'   => '#3b82f6',
            'bg'      => '#eff6ff',
            'route'   => 'reports.attendance',
        ],
        [
            'title'   => 'تقرير العقود',
            'desc'    => 'حالة جميع العقود مع فلترة حسب الحالة وإمكانية تصدير التقرير',
            'icon'    => 'bi-file-earmark-text',
            'color'   => '#16a34a',
            'bg'      => '#f0fdf4',
            'route'   => 'reports.contracts',
        ],
        [
            'title'   => 'تقرير التقييمات',
            'desc'    => 'نتائج تقييمات الأداء للموظفين مع متوسط الدرجات وإمكانية التصدير',
            'icon'    => 'bi-star-half',
            'color'   => '#d97706',
            'bg'      => '#fefce8',
            'route'   => 'reports.evaluations',
        ],
        [
            'title'   => 'تقرير المهام',
            'desc'    => 'حالة المهام المسندة لجميع الموظفين مع تفاصيل الإنجاز',
            'icon'    => 'bi-check2-square',
            'color'   => '#7c3aed',
            'bg'      => '#f5f3ff',
            'route'   => 'reports.tasks',
        ],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6">
        <div class="card" style="border-right:4px solid <?php echo e($r['color']); ?>;transition:0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
            <div class="card-body" style="padding:24px">
                <div class="d-flex align-items-start gap-3">
                    <div style="width:50px;height:50px;background:<?php echo e($r['bg']); ?>;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi <?php echo e($r['icon']); ?>" style="font-size:22px;color:<?php echo e($r['color']); ?>"></i>
                    </div>
                    <div style="flex:1">
                        <h5 style="font-weight:700;margin-bottom:6px"><?php echo e($r['title']); ?></h5>
                        <p style="font-size:13px;color:#6b7280;margin-bottom:16px"><?php echo e($r['desc']); ?></p>
                        <a href="<?php echo e(route($r['route'])); ?>" class="btn btn-save" style="font-size:13px;padding:8px 20px">
                            <i class="bi bi-arrow-left-circle"></i> فتح التقرير
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/reports/index.blade.php ENDPATH**/ ?>