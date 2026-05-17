<?php $__env->startSection('title', 'إدارة الإسنادات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة الإسنادات</h4>
    <a href="<?php echo e(route('assignments.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> إضافة إسناد</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card mb-3"><div class="card-body" style="padding:15px">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="بحث باسم الموظف..." value="<?php echo e(request('search')); ?>"></div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">كل الحالات</option>
                <?php $__currentLoopData = ['active'=>'نشط','completed'=>'منتهي','cancelled'=>'ملغي']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v); ?>" <?php echo e(request('status')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="location_id" class="form-select">
                <option value="">كل المواقع</option>
                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($loc->id); ?>" <?php echo e(request('location_id')==$loc->id?'selected':''); ?>><?php echo e($loc->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="company_id" class="form-select">
                <option value="">كل الشركات</option>
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $co): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($co->id); ?>" <?php echo e(request('company_id')==$co->id?'selected':''); ?>><?php echo e($co->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-save flex-fill">بحث</button>
            <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-back">مسح</a>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة الإسنادات</span>
        <span style="color:#9ca3af;font-size:13px"><?php echo e($assignments->total()); ?> إسناد</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>الموظف</th><th>الموقع</th><th>الشركة</th><th>الدور</th><th>من</th><th>إلى</th><th>الحالة</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asgn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $sColors = ['active'=>'#16a34a','completed'=>'#6b7280','cancelled'=>'#dc2626'];
                    $sBgs    = ['active'=>'#dcfce7','completed'=>'#f3f4f6','cancelled'=>'#fee2e2'];
                ?>
                <tr>
                    <td><?php echo e($loop->iteration + ($assignments->currentPage()-1)*$assignments->perPage()); ?></td>
                    <td style="font-weight:600"><?php echo e($asgn->employee->name ?? '-'); ?></td>
                    <td>
                        <?php if($asgn->location): ?>
                            <div style="font-size:13px;font-weight:600"><?php echo e($asgn->location->name); ?></div>
                            <?php if($asgn->location->region): ?>
                            <div style="font-size:11px;color:#9ca3af"><?php echo e($asgn->location->region->name); ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color:#9ca3af">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px"><?php echo e($asgn->company->name ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($asgn->role ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($asgn->start_date?->format('Y-m-d') ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($asgn->end_date?->format('Y-m-d') ?? 'مفتوح'); ?></td>
                    <td><span style="background:<?php echo e($sBgs[$asgn->status]??'#f3f4f6'); ?>;color:<?php echo e($sColors[$asgn->status]??'#6b7280'); ?>;padding:3px 9px;border-radius:20px;font-size:12px"><?php echo e($asgn->status_label); ?></span></td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('assignments.show', $asgn->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('assignments.edit', $asgn->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('assignments.destroy', $asgn->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('حذف الإسناد؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-person-check" style="font-size:30px"></i><p class="mt-2">لا توجد إسنادات</p></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($assignments->hasPages()): ?>
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px"><?php echo e($assignments->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/assignments/index.blade.php ENDPATH**/ ?>