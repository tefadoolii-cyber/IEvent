<?php $__env->startSection('title', 'تقرير الحضور'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-calendar-check"></i> تقرير الحضور الشهري</h4>
    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <label class="form-label" style="font-size:13px">الشهر</label>
            <input type="month" name="month" class="form-control" value="<?php echo e($month); ?>" style="font-size:13px">
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

<div class="row g-3 mb-4">
    <?php
        $totalPresent = $summary->sum('present');
        $totalAbsent  = $summary->sum('absent');
        $totalLate    = $summary->sum('late');
    ?>
    <?php $__currentLoopData = [
        ['val'=>$summary->count(), 'label'=>'الموظفون',  'color'=>'#374151'],
        ['val'=>$totalPresent,      'label'=>'حضور كلي',  'color'=>'#16a34a'],
        ['val'=>$totalAbsent,       'label'=>'غياب كلي',  'color'=>'#dc2626'],
        ['val'=>$totalLate,         'label'=>'تأخر كلي',  'color'=>'#d97706'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid <?php echo e($s['color']); ?>">
            <div style="font-size:26px;font-weight:800;color:<?php echo e($s['color']); ?>"><?php echo e($s['val']); ?></div>
            <div style="font-size:12px;color:#9ca3af"><?php echo e($s['label']); ?></div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if($chartData->count()): ?>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><span style="font-weight:600">توزيع الحضور</span></div>
            <div class="card-body" style="padding:20px;display:flex;align-items:center;justify-content:center">
                <div style="position:relative;width:100%;max-width:340px;max-height:280px">
                    <canvas id="attendanceChart" style="max-width:100%;max-height:280px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><span style="font-weight:600">الإحصائيات التفصيلية</span></div>
            <div class="card-body" style="padding:20px">
                <?php
                    $grandTotal = $chartData->sum();
                ?>
                <?php $__currentLoopData = ['present'=>['حضور','#16a34a','#dcfce7'],'absent'=>['غياب','#dc2626','#fee2e2'],'late'=>['تأخر','#d97706','#fef3c7']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>[$lbl,$color,$bg]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $val = $chartData->get($key, 0); $pct = $grandTotal > 0 ? round($val/$grandTotal*100) : 0; ?>
                <div style="margin-bottom:14px">
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:13px">
                        <span style="font-weight:600;color:<?php echo e($color); ?>"><?php echo e($lbl); ?></span>
                        <span style="color:#6b7280"><?php echo e($val); ?> (<?php echo e($pct); ?>%)</span>
                    </div>
                    <div style="background:#f3f4f6;border-radius:10px;height:8px">
                        <div style="width:<?php echo e($pct); ?>%;background:<?php echo e($color); ?>;border-radius:10px;height:8px;transition:width 0.5s"></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <?php if($summary->count()): ?>
        <div class="table-responsive">
        <table class="table mb-0" style="min-width:600px">
            <thead>
                <tr><th>الموظف</th><th>رقم الموظف</th><th style="color:#16a34a">حضور</th><th style="color:#dc2626">غياب</th><th style="color:#d97706">تأخر</th><th>الإجمالي</th><th>النسبة</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $summary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $pct = $row['total'] > 0 ? round($row['present']/$row['total']*100) : 0; ?>
                <tr>
                    <td style="font-weight:600;font-size:13px"><?php echo e($row['employee']?->name ?? '—'); ?></td>
                    <td style="font-size:12px;color:#9ca3af"><?php echo e($row['employee']?->employee_number ?? '—'); ?></td>
                    <td style="font-size:13px;color:#16a34a;font-weight:600"><?php echo e($row['present']); ?></td>
                    <td style="font-size:13px;color:#dc2626;font-weight:600"><?php echo e($row['absent']); ?></td>
                    <td style="font-size:13px;color:#d97706;font-weight:600"><?php echo e($row['late']); ?></td>
                    <td style="font-size:13px"><?php echo e($row['total']); ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div style="flex:1;background:#f3f4f6;border-radius:10px;height:6px">
                                <div style="width:<?php echo e($pct); ?>%;background:#16a34a;border-radius:10px;height:6px"></div>
                            </div>
                            <span style="font-size:11px;color:#6b7280;min-width:30px"><?php echo e($pct); ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-calendar" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد بيانات لهذا الشهر</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if($chartData->count()): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('attendanceChart'), {
    type: 'doughnut',
    data: {
        labels: ['حضور','غياب','تأخر'],
        datasets: [{
            data: [
                <?php echo e($chartData->get('present', 0)); ?>,
                <?php echo e($chartData->get('absent', 0)); ?>,
                <?php echo e($chartData->get('late', 0)); ?>,
            ],
            backgroundColor: ['#16a34a','#dc2626','#d97706'],
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 12 }, padding: 12 } } }
    }
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/reports/attendance.blade.php ENDPATH**/ ?>