<?php $__env->startSection('title', 'الاستبيانات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-clipboard-data"></i> الاستبيانات</h4>
    <a href="<?php echo e(route('surveys.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> استبيان جديد</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <?php $__currentLoopData = [
        ['val'=>$stats['total'],  'label'=>'إجمالي',  'color'=>'#374151'],
        ['val'=>$stats['draft'],  'label'=>'مسودة',   'color'=>'#6b7280'],
        ['val'=>$stats['active'], 'label'=>'نشطة',    'color'=>'#16a34a'],
        ['val'=>$stats['closed'], 'label'=>'مغلقة',   'color'=>'#dc2626'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid <?php echo e($s['color']); ?>">
            <div style="font-size:26px;font-weight:800;color:<?php echo e($s['color']); ?>"><?php echo e($s['val']); ?></div>
            <div style="font-size:12px;color:#9ca3af"><?php echo e($s['label']); ?></div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="عنوان الاستبيان..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="draft"  <?php echo e(request('status')=='draft'  ?'selected':''); ?>>مسودة</option>
                <option value="active" <?php echo e(request('status')=='active' ?'selected':''); ?>>نشط</option>
                <option value="closed" <?php echo e(request('status')=='closed' ?'selected':''); ?>>مغلق</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        <?php if(request()->hasAny(['search','status'])): ?>
        <div class="col-auto"><a href="<?php echo e(route('surveys.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a></div>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if($surveys->count()): ?>
        <?php
            $sc=['draft'=>'#6b7280','active'=>'#16a34a','closed'=>'#dc2626'];
            $sb=['draft'=>'#f3f4f6','active'=>'#dcfce7','closed'=>'#fee2e2'];
        ?>
        <table class="table mb-0">
            <thead>
                <tr><th>الاستبيان</th><th>الأسئلة</th><th>الردود</th><th>الحالة</th><th>بداية/نهاية</th><th>أنشأه</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $surveys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px"><?php echo e($sv->title); ?></div>
                        <?php if($sv->description): ?>
                        <div style="font-size:11px;color:#9ca3af"><?php echo e(Str::limit($sv->description, 50)); ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px;text-align:center"><?php echo e($sv->questions_count); ?></td>
                    <td style="font-size:13px;text-align:center"><?php echo e($sv->responses_count); ?></td>
                    <td>
                        <span style="background:<?php echo e($sb[$sv->status]??'#f3f4f6'); ?>;color:<?php echo e($sc[$sv->status]??'#6b7280'); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($sv->status_label); ?>

                        </span>
                    </td>
                    <td style="font-size:11px;color:#9ca3af">
                        <?php echo e($sv->starts_at?->format('Y-m-d') ?? '—'); ?>

                        <?php if($sv->ends_at): ?> ← <?php echo e($sv->ends_at->format('Y-m-d')); ?> <?php endif; ?>
                    </td>
                    <td style="font-size:12px"><?php echo e($sv->creator?->name ?? '—'); ?></td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('surveys.show', $sv->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('surveys.edit', $sv->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('surveys.destroy', $sv->id)); ?>" method="POST" onsubmit="return confirm('حذف هذا الاستبيان؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($surveys->withQueryString()->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-clipboard-data" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد استبيانات</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/surveys/index.blade.php ENDPATH**/ ?>