

<?php $__env->startSection('title', 'إدارة الموظفين'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة الموظفين</h4>
    <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> إضافة موظف
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600; font-size:15px;">قائمة الموظفين</span>
        <span style="color:#9ca3af; font-size:13px;">إجمالي: <?php echo e(count($employees)); ?> موظف</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم ورقم الموظف</th>
                    <th>رقم الجوال</th>
                    <th>القسم</th>
                    <th>المسمى الوظيفي</th>
                    <th>الحالة</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td>
                        <div style="font-weight:600"><?php echo e($employee->name); ?></div>
                        <div style="color:#9ca3af; font-size:12px"><?php echo e($employee->employee_number); ?></div>
                    </td>
                    <td><?php echo e($employee->phone ?? '-'); ?></td>
                    <td><?php echo e($employee->department ?? '-'); ?></td>
                    <td><?php echo e($employee->position ?? '-'); ?></td>
                    <td>
                        <?php if($employee->status == 'active'): ?>
                            <span class="badge-active">نشط</span>
                        <?php else: ?>
                            <span class="badge-inactive">غير نشط</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('employees.show', $employee->id)); ?>" class="btn btn-edit">
                            <i class="bi bi-eye"></i> عرض
                        </a>
                        <a href="<?php echo e(route('employees.edit', $employee->id)); ?>" class="btn btn-edit">
                            <i class="bi bi-pencil"></i> تعديل
                        </a>
                        <form action="<?php echo e(route('employees.destroy', $employee->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">
                                <i class="bi bi-trash"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-4" style="color:#9ca3af">
                        <i class="bi bi-inbox" style="font-size:30px"></i>
                        <p class="mt-2">لا يوجد موظفين بعد</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/employees/index.blade.php ENDPATH**/ ?>