<?php $__env->startSection('title', 'الباقات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-box-seam"></i> إدارة الباقات</h4>
    <a href="<?php echo e(route('packages.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> باقة جديدة</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <?php $__currentLoopData = [
        ['val'=>$stats['total'],    'label'=>'إجمالي',    'color'=>'#374151'],
        ['val'=>$stats['active'],   'label'=>'نشطة',      'color'=>'#16a34a'],
        ['val'=>$stats['inactive'], 'label'=>'غير نشطة',  'color'=>'#dc2626'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-md-4">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid <?php echo e($s['color']); ?>">
            <div style="font-size:26px;font-weight:800;color:<?php echo e($s['color']); ?>"><?php echo e($s['val']); ?></div>
            <div style="font-size:12px;color:#9ca3af"><?php echo e($s['label']); ?></div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="اسم الباقة..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="active"   <?php echo e(request('status')=='active'   ?'selected':''); ?>>نشطة</option>
                <option value="inactive" <?php echo e(request('status')=='inactive' ?'selected':''); ?>>غير نشطة</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="company_id" class="form-select" style="font-size:13px">
                <option value="">كل الشركات</option>
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php echo e(request('company_id')==$c->id?'selected':''); ?>><?php echo e($c->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        <?php if(request()->hasAny(['search','status','company_id'])): ?>
        <div class="col-auto"><a href="<?php echo e(route('packages.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a></div>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if($packages->count()): ?>
        <table class="table mb-0">
            <thead>
                <tr><th>الباقة</th><th>الشركة</th><th>السعر</th><th>الخدمات</th><th>الحالة</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px"><?php echo e($pkg->name); ?></div>
                        <?php if($pkg->description): ?>
                        <div style="font-size:11px;color:#9ca3af"><?php echo e(Str::limit($pkg->description, 50)); ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px"><?php echo e($pkg->company?->name ?? '—'); ?></td>
                    <td style="font-size:13px;font-weight:600"><?php echo e(number_format($pkg->price, 2)); ?> ر.س</td>
                    <td>
                        <?php if($pkg->services): ?>
                            <?php $__currentLoopData = array_slice($pkg->services, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span style="background:#f3f4f6;color:#374151;padding:2px 8px;border-radius:12px;font-size:11px;margin-left:3px"><?php echo e($s); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($pkg->services) > 3): ?>
                                <span style="font-size:11px;color:#9ca3af">+<?php echo e(count($pkg->services)-3); ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color:#9ca3af;font-size:12px">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span style="background:<?php echo e($pkg->status==='active'?'#dcfce7':'#fee2e2'); ?>;color:<?php echo e($pkg->status==='active'?'#16a34a':'#dc2626'); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($pkg->status_label); ?>

                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('packages.edit', $pkg->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('packages.destroy', $pkg->id)); ?>" method="POST" onsubmit="return confirm('حذف هذه الباقة؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($packages->withQueryString()->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-box-seam" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد باقات</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/packages/index.blade.php ENDPATH**/ ?>