<?php $__env->startSection('title', 'سجلات الزيارات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-geo-alt"></i> سجلات الزيارات</h4>
    <a href="<?php echo e(route('visits.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> تسجيل زيارة</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="اسم الموظف..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="pending"   <?php echo e(request('status')=='pending'   ?'selected':''); ?>>معلق</option>
                <option value="completed" <?php echo e(request('status')=='completed' ?'selected':''); ?>>مكتمل</option>
                <option value="cancelled" <?php echo e(request('status')=='cancelled' ?'selected':''); ?>>ملغي</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        <?php if(request()->hasAny(['search','date','status'])): ?>
        <div class="col-auto"><a href="<?php echo e(route('visits.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a></div>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if($visits->count()): ?>
        <table class="table mb-0">
            <thead>
                <tr><th>الموظف</th><th>الموقع</th><th>تاريخ الزيارة</th><th>الحضور</th><th>الانصراف</th><th>الحالة</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $sColors = ['pending'=>'#d97706','completed'=>'#16a34a','cancelled'=>'#dc2626'];
                    $sBgs    = ['pending'=>'#fef3c7','completed'=>'#dcfce7','cancelled'=>'#fee2e2'];
                ?>
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px"><?php echo e($v->employee->name); ?></div>
                        <div style="font-size:11px;color:#9ca3af;font-family:monospace"><?php echo e($v->employee->employee_number); ?></div>
                    </td>
                    <td style="font-size:13px"><?php echo e($v->location?->name ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($v->visit_date->format('Y-m-d')); ?></td>
                    <td style="font-size:13px;font-family:monospace"><?php echo e($v->check_in_time ?? '-'); ?></td>
                    <td style="font-size:13px;font-family:monospace"><?php echo e($v->check_out_time ?? '-'); ?></td>
                    <td>
                        <span style="background:<?php echo e($sBgs[$v->status]??'#f3f4f6'); ?>;color:<?php echo e($sColors[$v->status]??'#6b7280'); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($v->status_label); ?>

                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('visits.show', $v->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('visits.edit', $v->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('visits.destroy', $v->id)); ?>" method="POST" onsubmit="return confirm('حذف هذه الزيارة؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($visits->withQueryString()->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-geo-alt" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد زيارات مسجلة</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/visits/index.blade.php ENDPATH**/ ?>