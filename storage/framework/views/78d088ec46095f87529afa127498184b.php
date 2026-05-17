<?php $__env->startSection('title', 'تقرير العقود'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-file-earmark-text"></i> تقرير العقود</h4>
    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <?php $__currentLoopData = ['draft'=>'مسودة','sent'=>'مُرسل','signed'=>'موقّع','cancelled'=>'ملغي']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e($status==$val?'selected':''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> عرض</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo e(request()->fullUrlWithQuery(['export'=>'excel'])); ?>" class="btn" style="background:#16a34a;color:white;font-size:13px;padding:8px 16px">
                <i class="bi bi-file-earmark-excel"></i> تصدير Excel
            </a>
        </div>
    </form>
</div>

<?php if($statusCounts->count()): ?>
<div class="card mb-4">
    <div class="card-header"><span style="font-weight:600">توزيع العقود حسب الحالة</span></div>
    <div class="card-body" style="padding:20px">
        <canvas id="contractChart" height="80"></canvas>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <?php if($contracts->count()): ?>
        <?php
            $statusLabels = ['draft'=>'مسودة','sent'=>'مُرسل','signed'=>'موقّع','cancelled'=>'ملغي'];
            $sc = ['draft'=>'#6b7280','sent'=>'#3b82f6','signed'=>'#16a34a','cancelled'=>'#dc2626'];
            $sb = ['draft'=>'#f3f4f6','sent'=>'#eff6ff','signed'=>'#dcfce7','cancelled'=>'#fee2e2'];
        ?>
        <table class="table mb-0">
            <thead>
                <tr><th>الموظف</th><th>نوع العقد</th><th>البداية</th><th>الانتهاء</th><th>الراتب</th><th>الحالة</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-weight:600;font-size:13px"><?php echo e($c->employee?->name ?? '—'); ?></td>
                    <td style="font-size:13px"><?php echo e($c->type ?? '—'); ?></td>
                    <td style="font-size:12px;color:#9ca3af"><?php echo e($c->start_date ?? '—'); ?></td>
                    <td style="font-size:12px;color:#9ca3af"><?php echo e($c->end_date ?? '—'); ?></td>
                    <td style="font-size:13px"><?php echo e($c->salary ? number_format($c->salary, 0).' ر.س' : '—'); ?></td>
                    <td>
                        <span style="background:<?php echo e($sb[$c->status]??'#f3f4f6'); ?>;color:<?php echo e($sc[$c->status]??'#6b7280'); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($statusLabels[$c->status] ?? $c->status); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-file-earmark" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد عقود</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if($statusCounts->count()): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('contractChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($statusCounts->keys()->map(fn($k)=>['draft'=>'مسودة','sent'=>'مُرسل','signed'=>'موقّع','cancelled'=>'ملغي'][$k]??$k)->values()); ?>,
        datasets: [{
            label: 'عدد العقود',
            data: <?php echo json_encode($statusCounts->values()); ?>,
            backgroundColor: ['#f3f4f6','#eff6ff','#dcfce7','#fee2e2'],
            borderColor: ['#6b7280','#3b82f6','#16a34a','#dc2626'],
            borderWidth: 2,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/reports/contracts.blade.php ENDPATH**/ ?>