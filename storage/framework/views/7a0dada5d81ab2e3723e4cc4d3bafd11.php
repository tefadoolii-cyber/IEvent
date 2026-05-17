<?php $__env->startSection('title', 'إدارة الأجهزة والعهد'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة الأجهزة والعهد</h4>
    <a href="<?php echo e(route('assets.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> إضافة جهاز</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card mb-3"><div class="card-body" style="padding:15px">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="بحث بالاسم أو الرقم التسلسلي..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">كل الحالات</option>
                <?php $__currentLoopData = ['available'=>'متاح','assigned'=>'مُسلَّم','maintenance'=>'صيانة','retired'=>'مُهلَك']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v); ?>" <?php echo e(request('status')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-save flex-fill">بحث</button>
            <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-back">مسح</a>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة الأجهزة</span>
        <span style="color:#9ca3af;font-size:13px"><?php echo e($assets->total()); ?> جهاز</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>الجهاز</th><th>النوع</th><th>الرقم التسلسلي</th><th>الحالة</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $sColors = ['available'=>'#16a34a','assigned'=>'#d97706','maintenance'=>'#2563eb','retired'=>'#dc2626'];
                    $sBgs    = ['available'=>'#dcfce7','assigned'=>'#fef3c7','maintenance'=>'#dbeafe','retired'=>'#fee2e2'];
                ?>
                <tr>
                    <td><?php echo e($loop->iteration + ($assets->currentPage()-1)*$assets->perPage()); ?></td>
                    <td>
                        <div style="font-weight:600"><?php echo e($asset->name); ?></div>
                        <?php if($asset->brand): ?> <div style="color:#9ca3af;font-size:12px"><?php echo e($asset->brand); ?> <?php echo e($asset->model); ?></div> <?php endif; ?>
                    </td>
                    <td><?php echo e($asset->type ?? '-'); ?></td>
                    <td style="font-family:monospace;font-size:13px"><?php echo e($asset->serial_number ?? '-'); ?></td>
                    <td><span style="background:<?php echo e($sBgs[$asset->status]??'#f3f4f6'); ?>;color:<?php echo e($sColors[$asset->status]??'#6b7280'); ?>;padding:3px 9px;border-radius:20px;font-size:12px"><?php echo e($asset->status_label); ?></span></td>
                    <td>
                        <a href="<?php echo e(route('assets.show', $asset->id)); ?>" class="btn btn-edit"><i class="bi bi-eye"></i></a>
                        <a href="<?php echo e(route('assets.edit', $asset->id)); ?>" class="btn btn-edit"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('assets.destroy', $asset->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('حذف الجهاز؟')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-laptop" style="font-size:30px"></i><p class="mt-2">لا توجد أجهزة</p></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($assets->hasPages()): ?>
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px"><?php echo e($assets->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/assets/index.blade.php ENDPATH**/ ?>