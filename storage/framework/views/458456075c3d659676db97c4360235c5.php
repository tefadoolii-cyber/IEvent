<?php $__env->startSection('title', 'التقييمات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-star"></i> تقييمات الموظفين</h4>
    <a href="<?php echo e(route('evaluations.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> تقييم جديد</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>


<div class="row g-3 mb-4">
    <?php $__currentLoopData = [
        ['val'=>$stats['total'],     'label'=>'إجمالي',   'color'=>'#374151','bg'=>'#f3f4f6'],
        ['val'=>$stats['draft'],     'label'=>'مسودة',    'color'=>'#d97706','bg'=>'#fef3c7'],
        ['val'=>$stats['submitted'], 'label'=>'مُقدَّم',  'color'=>'#2563eb','bg'=>'#dbeafe'],
        ['val'=>$stats['approved'],  'label'=>'معتمد',    'color'=>'#16a34a','bg'=>'#dcfce7'],
        ['val'=>$stats['avg_score'], 'label'=>'متوسط الدرجة','color'=>'#7c3aed','bg'=>'#ede9fe'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-md">
        <div class="card" style="text-align:center;padding:14px 10px;border-right:4px solid <?php echo e($s['color']); ?>">
            <div style="font-size:24px;font-weight:800;color:<?php echo e($s['color']); ?>"><?php echo e($s['val']); ?></div>
            <div style="font-size:12px;color:#9ca3af"><?php echo e($s['label']); ?></div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="اسم الموظف..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-2">
            <input type="text" name="period" class="form-control" placeholder="الفترة (2026-Q1)" value="<?php echo e(request('period')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="draft"     <?php echo e(request('status')=='draft'     ?'selected':''); ?>>مسودة</option>
                <option value="submitted" <?php echo e(request('status')=='submitted' ?'selected':''); ?>>مُقدَّم</option>
                <option value="approved"  <?php echo e(request('status')=='approved'  ?'selected':''); ?>>معتمد</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        <?php if(request()->hasAny(['search','period','status'])): ?>
        <div class="col-auto"><a href="<?php echo e(route('evaluations.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a></div>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if($evaluations->count()): ?>
        <table class="table mb-0">
            <thead>
                <tr><th>الموظف</th><th>الفترة</th><th>المُقيِّم</th><th>الدرجة</th><th>الحالة</th><th>التاريخ</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $evaluations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px"><?php echo e($eval->employee->name); ?></div>
                        <div style="font-size:11px;color:#9ca3af"><?php echo e($eval->employee->department); ?></div>
                    </td>
                    <td style="font-size:13px;font-family:monospace"><?php echo e($eval->period); ?></td>
                    <td style="font-size:13px"><?php echo e($eval->evaluator->name); ?></td>
                    <td>
                        <span style="font-size:15px;font-weight:800;color:<?php echo e($eval->score_color); ?>"><?php echo e($eval->total_score); ?></span>
                        <span style="font-size:11px;color:#9ca3af">/100</span>
                    </td>
                    <td>
                        <?php
                            $sc=['draft'=>'#d97706','submitted'=>'#2563eb','approved'=>'#16a34a'];
                            $sb=['draft'=>'#fef3c7','submitted'=>'#dbeafe','approved'=>'#dcfce7'];
                        ?>
                        <span style="background:<?php echo e($sb[$eval->status]??'#f3f4f6'); ?>;color:<?php echo e($sc[$eval->status]??'#6b7280'); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($eval->status_label); ?>

                        </span>
                    </td>
                    <td style="font-size:12px;color:#9ca3af"><?php echo e($eval->created_at->format('Y-m-d')); ?></td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('evaluations.show', $eval->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('evaluations.edit', $eval->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('evaluations.destroy', $eval->id)); ?>" method="POST" onsubmit="return confirm('حذف هذا التقييم؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($evaluations->withQueryString()->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-star" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد تقييمات</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/evaluations/index.blade.php ENDPATH**/ ?>