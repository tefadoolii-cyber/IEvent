<?php $__env->startSection('title', 'تقرير المهام'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-check2-square"></i> تقرير المهام</h4>
    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <?php $__currentLoopData = ['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php echo e($status==$val?'selected':''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> عرض</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo e(request()->fullUrlWithQuery(['export'=>'excel'])); ?>" class="btn" style="background:#16a34a;color:white;font-size:13px;padding:8px 16px">
                <i class="bi bi-file-earmark-excel"></i> تصدير Excel
            </a>
        </div>
    </form>
</div>

<?php if($statusCounts->count()): ?>
<div class="row g-3 mb-4">
    <?php $__currentLoopData = ['new'=>['لون'=>'#6b7280','اسم'=>'جديدة'],'in_progress'=>['لون'=>'#3b82f6','اسم'=>'قيد التنفيذ'],'completed'=>['لون'=>'#16a34a','اسم'=>'مكتملة']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st=>$info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid <?php echo e($info['لون']); ?>">
            <div style="font-size:26px;font-weight:800;color:<?php echo e($info['لون']); ?>"><?php echo e($statusCounts->get($st, 0)); ?></div>
            <div style="font-size:12px;color:#9ca3af"><?php echo e($info['اسم']); ?></div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <?php if($tasks->count()): ?>
        <?php
            $sc = ['new'=>'#6b7280','in_progress'=>'#3b82f6','completed'=>'#16a34a'];
            $sb = ['new'=>'#f3f4f6','in_progress'=>'#eff6ff','completed'=>'#dcfce7'];
            $sl = ['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة'];
        ?>
        <table class="table mb-0">
            <thead>
                <tr><th>المهمة</th><th>الموظف</th><th>الأولوية</th><th>الاستحقاق</th><th>الحالة</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-weight:600;font-size:13px"><?php echo e($t->title); ?></td>
                    <td style="font-size:13px"><?php echo e($t->employee?->name ?? '—'); ?></td>
                    <td style="font-size:12px"><?php echo e($t->priority ?? '—'); ?></td>
                    <td style="font-size:12px;color:<?php echo e($t->due_date && $t->due_date < today() && $t->status!='completed' ? '#dc2626' : '#9ca3af'); ?>">
                        <?php echo e($t->due_date ?? '—'); ?>

                    </td>
                    <td>
                        <span style="background:<?php echo e($sb[$t->status]??'#f3f4f6'); ?>;color:<?php echo e($sc[$t->status]??'#6b7280'); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($sl[$t->status] ?? $t->status); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-check2-square" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد مهام</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/reports/tasks.blade.php ENDPATH**/ ?>