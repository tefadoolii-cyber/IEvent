<?php $__env->startSection('title', 'إدارة المهام'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة المهام</h4>
    <a href="<?php echo e(route('tasks.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> إضافة مهمة</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>


<div class="card mb-3">
    <div class="card-body" style="padding:15px">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="بحث بالعنوان أو الموظف..." value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">كل الحالات</option>
                    <?php $__currentLoopData = ['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة','cancelled'=>'ملغاة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v); ?>" <?php echo e(request('status')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="priority" class="form-select">
                    <option value="">كل الأولويات</option>
                    <?php $__currentLoopData = ['low'=>'منخفضة','medium'=>'متوسطة','high'=>'عالية','urgent'=>'عاجلة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v); ?>" <?php echo e(request('priority')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="employee_id" class="form-select">
                    <option value="">كل الموظفين</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->id); ?>" <?php echo e(request('employee_id')==$emp->id?'selected':''); ?>><?php echo e($emp->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-save flex-fill">بحث</button>
                <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-back">مسح</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة المهام</span>
        <span style="color:#9ca3af;font-size:13px"><?php echo e($tasks->total()); ?> مهمة</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>المهمة</th><th>الموظف</th><th>الأولوية</th><th>تاريخ الاستحقاق</th><th>الحالة</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $pColors = ['low'=>'#6b7280','medium'=>'#d97706','high'=>'#dc2626','urgent'=>'#7c3aed'];
                    $pBgs    = ['low'=>'#f3f4f6','medium'=>'#fef3c7','high'=>'#fee2e2','urgent'=>'#ede9fe'];
                    $sColors = ['new'=>'#6b7280','in_progress'=>'#d97706','completed'=>'#16a34a','cancelled'=>'#dc2626'];
                    $sBgs    = ['new'=>'#f3f4f6','in_progress'=>'#fef3c7','completed'=>'#dcfce7','cancelled'=>'#fee2e2'];
                ?>
                <tr>
                    <td><?php echo e($loop->iteration + ($tasks->currentPage()-1)*$tasks->perPage()); ?></td>
                    <td>
                        <div style="font-weight:600"><?php echo e($task->title); ?></div>
                        <?php if($task->isOverdue()): ?>
                            <small style="color:#dc2626"><i class="bi bi-exclamation-triangle"></i> متأخرة</small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($task->employee->name ?? '-'); ?></td>
                    <td><span style="background:<?php echo e($pBgs[$task->priority]??'#f3f4f6'); ?>;color:<?php echo e($pColors[$task->priority]??'#6b7280'); ?>;padding:3px 9px;border-radius:20px;font-size:12px"><?php echo e($task->priority_label); ?></span></td>
                    <td style="font-size:13px"><?php echo e($task->due_date?->format('Y-m-d') ?? '-'); ?></td>
                    <td><span style="background:<?php echo e($sBgs[$task->status]??'#f3f4f6'); ?>;color:<?php echo e($sColors[$task->status]??'#6b7280'); ?>;padding:3px 9px;border-radius:20px;font-size:12px"><?php echo e($task->status_label); ?></span></td>
                    <td>
                        <a href="<?php echo e(route('tasks.edit', $task->id)); ?>" class="btn btn-edit"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('tasks.destroy', $task->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('حذف المهمة؟')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-inbox" style="font-size:30px"></i><p class="mt-2">لا توجد مهام</p></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($tasks->hasPages()): ?>
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px">
        <?php echo e($tasks->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/tasks/index.blade.php ENDPATH**/ ?>