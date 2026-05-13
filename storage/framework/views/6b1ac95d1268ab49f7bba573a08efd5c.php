

<?php $__env->startSection('title', 'إدارة الحضور والانصراف'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة الحضور والانصراف</h4>
    <a href="<?php echo e(route('attendance.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> تسجيل حضور
    </a>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#16a34a"><?php echo e($attendance->where('status', 'present')->count()); ?></div>
            <div style="color:#6b7280; font-size:13px">حاضر اليوم</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#dc2626"><?php echo e($attendance->where('status', 'absent')->count()); ?></div>
            <div style="color:#6b7280; font-size:13px">غائب</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#d97706"><?php echo e($attendance->where('status', 'late')->count()); ?></div>
            <div style="color:#6b7280; font-size:13px">متأخر</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="padding:20px">
            <div style="font-size:28px; font-weight:700; color:#1a1a2e"><?php echo e($attendance->total()); ?></div>
            <div style="color:#6b7280; font-size:13px">إجمالي السجلات</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">سجلات الحضور</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الموظف</th>
                    <th>التاريخ</th>
                    <th>الحضور</th>
                    <th>الانصراف</th>
                    <th>الحالة</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $attendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td>
                        <div style="font-weight:600"><?php echo e($record->employee->name ?? '-'); ?></div>
                        <div style="color:#9ca3af; font-size:12px"><?php echo e($record->employee->employee_number ?? ''); ?></div>
                    </td>
                    <td><?php echo e($record->date); ?></td>
                    <td><?php echo e($record->check_in ?? '-'); ?></td>
                    <td><?php echo e($record->check_out ?? '-'); ?></td>
                    <td>
                        <?php if($record->status == 'present'): ?>
                            <span class="badge-active">حاضر</span>
                        <?php elseif($record->status == 'absent'): ?>
                            <span class="badge-inactive">غائب</span>
                        <?php else: ?>
                            <span class="badge-late">متأخر</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('attendance.edit', $record->id)); ?>" class="btn btn-edit">تعديل</a>
                        <form action="<?php echo e(route('attendance.destroy', $record->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-4" style="color:#9ca3af">لا يوجد سجلات</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3"><?php echo e($attendance->links()); ?></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/attendance/index.blade.php ENDPATH**/ ?>