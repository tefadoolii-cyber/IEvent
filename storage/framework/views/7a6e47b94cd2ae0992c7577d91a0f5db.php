<?php $__env->startSection('title', 'لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>لوحة التحكم</h4>
    <span style="color:#9ca3af; font-size:14px"><?php echo e(now()->translatedFormat('l، d F Y')); ?></span>
</div>


<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#4ade80; margin-bottom:8px"><i class="bi bi-people-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e"><?php echo e($totalEmployees); ?></div>
            <div style="color:#6b7280; font-size:13px">إجمالي الموظفين</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#3b82f6; margin-bottom:8px"><i class="bi bi-check-circle-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e"><?php echo e($todayPresent); ?></div>
            <div style="color:#6b7280; font-size:13px">حاضرون اليوم</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#f59e0b; margin-bottom:8px"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e"><?php echo e($activeContracts); ?></div>
            <div style="color:#6b7280; font-size:13px">عقود سارية</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#ef4444; margin-bottom:8px"><i class="bi bi-x-circle-fill"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e"><?php echo e($todayAbsent); ?></div>
            <div style="color:#6b7280; font-size:13px">غائبون اليوم</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:20px">
            <div style="font-size:32px; color:#7c3aed; margin-bottom:8px"><i class="bi bi-headset"></i></div>
            <div style="font-size:28px; font-weight:800; color:#1a1a2e"><?php echo e($openTickets); ?></div>
            <div style="color:#6b7280; font-size:13px">تذاكر مفتوحة</div>
        </div>
    </div>
</div>

<div class="row g-3">
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-person-plus"></i> آخر الموظفين المضافين</span>
                <a href="<?php echo e(route('employees.index')); ?>" style="font-size:13px; color:#9ca3af">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>القسم</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $latestEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div style="font-weight:600; font-size:14px"><?php echo e($emp->name); ?></div>
                                <div style="color:#9ca3af; font-size:12px"><?php echo e($emp->employee_number); ?></div>
                            </td>
                            <td style="font-size:13px"><?php echo e($emp->department ?? '-'); ?></td>
                            <td>
                                <?php if($emp->status == 'active'): ?>
                                    <span class="badge-active">نشط</span>
                                <?php else: ?>
                                    <span class="badge-inactive">غير نشط</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" class="text-center py-3" style="color:#9ca3af">لا يوجد موظفين</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-calendar-check"></i> سجل حضور اليوم</span>
                <a href="<?php echo e(route('attendance.index')); ?>" style="font-size:13px; color:#9ca3af">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>وقت الحضور</th>
                            <th>وقت الانصراف</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $todayAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="font-size:14px; font-weight:600"><?php echo e($att->employee->name ?? '-'); ?></td>
                            <td style="font-size:13px"><?php echo e($att->check_in ?? '-'); ?></td>
                            <td style="font-size:13px"><?php echo e($att->check_out ?? '-'); ?></td>
                            <td>
                                <?php if($att->status == 'present'): ?>
                                    <span class="badge-present">حاضر</span>
                                <?php elseif($att->status == 'absent'): ?>
                                    <span class="badge-absent">غائب</span>
                                <?php else: ?>
                                    <span class="badge-late">متأخر</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" class="text-center py-3" style="color:#9ca3af">لا توجد سجلات اليوم</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-file-earmark-text"></i> آخر العقود</span>
                <a href="<?php echo e(route('contracts.index')); ?>" style="font-size:13px; color:#9ca3af">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>رقم العقد</th>
                            <th>الموظف</th>
                            <th>المسمى</th>
                            <th>الراتب</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $latestContracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $colors = ['draft' => '#6b7280', 'sent' => '#d97706', 'signed' => '#16a34a', 'cancelled' => '#dc2626'];
                            $bgs    = ['draft' => '#f3f4f6', 'sent' => '#fef3c7', 'signed' => '#dcfce7', 'cancelled' => '#fee2e2'];
                        ?>
                        <tr>
                            <td style="font-family:monospace;font-size:12px"><?php echo e($contract->contract_number); ?></td>
                            <td style="font-weight:600"><?php echo e($contract->employee->name); ?></td>
                            <td style="font-size:13px"><?php echo e($contract->position ?? '-'); ?></td>
                            <td style="font-size:13px"><?php echo e($contract->salary ? number_format($contract->salary, 0) . ' ر.س' : '-'); ?></td>
                            <td>
                                <span style="background:<?php echo e($bgs[$contract->status] ?? '#f3f4f6'); ?>;color:<?php echo e($colors[$contract->status] ?? '#6b7280'); ?>;padding:3px 10px;border-radius:20px;font-size:12px">
                                    <?php echo e($contract->status_label); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="text-center py-3" style="color:#9ca3af">لا توجد عقود بعد</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-bar-chart-line"></i> الحضور الشهري (آخر 6 أشهر)</span></div>
            <div class="card-body" style="padding:20px">
                <canvas id="attendanceChart" height="120"></canvas>
            </div>
        </div>
    </div>

    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-pie-chart"></i> الموظفون حسب القسم</span></div>
            <div class="card-body" style="padding:20px">
                <canvas id="deptChart" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
// الحضور الشهري
new Chart(document.getElementById('attendanceChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($attendanceChart->pluck('month')); ?>,
        datasets: [
            {
                label: 'حضور',
                data: <?php echo json_encode($attendanceChart->pluck('present')); ?>,
                backgroundColor: 'rgba(22,163,74,0.7)',
                borderColor: '#16a34a',
                borderWidth: 1,
            },
            {
                label: 'غياب',
                data: <?php echo json_encode($attendanceChart->pluck('absent')); ?>,
                backgroundColor: 'rgba(220,38,38,0.7)',
                borderColor: '#dc2626',
                borderWidth: 1,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});

// القسم
<?php if($deptChart->count()): ?>
new Chart(document.getElementById('deptChart'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($deptChart->keys()); ?>,
        datasets: [{
            data: <?php echo json_encode($deptChart->values()); ?>,
            backgroundColor: ['#3b82f6','#16a34a','#d97706','#dc2626','#7c3aed','#0891b2','#db2777'],
            borderWidth: 2,
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } } }
});
<?php else: ?>
document.getElementById('deptChart').parentElement.innerHTML = '<p style="text-align:center;color:#9ca3af;font-size:13px;padding:40px 0">لا توجد بيانات</p>';
<?php endif; ?>
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/dashboard.blade.php ENDPATH**/ ?>