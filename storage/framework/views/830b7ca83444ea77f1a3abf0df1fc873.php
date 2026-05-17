<?php $__env->startSection('title', 'طلبات التوظيف'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-people"></i> طلبات التوظيف</h4>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:18px 12px">
            <div style="font-size:28px;font-weight:800;color:#374151"><?php echo e($stats['total']); ?></div>
            <div style="font-size:12px;color:#9ca3af;margin-top:4px">إجمالي الطلبات</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:18px 12px;border-right:4px solid #d97706">
            <div style="font-size:28px;font-weight:800;color:#d97706"><?php echo e($stats['pending']); ?></div>
            <div style="font-size:12px;color:#9ca3af;margin-top:4px">معلق</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:18px 12px;border-right:4px solid #16a34a">
            <div style="font-size:28px;font-weight:800;color:#16a34a"><?php echo e($stats['accepted']); ?></div>
            <div style="font-size:12px;color:#9ca3af;margin-top:4px">مقبول</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:18px 12px;border-right:4px solid #dc2626">
            <div style="font-size:28px;font-weight:800;color:#dc2626"><?php echo e($stats['rejected']); ?></div>
            <div style="font-size:12px;color:#9ca3af;margin-top:4px">مرفوض</div>
        </div>
    </div>
</div>


<div class="card mb-3">
    <form method="GET" action="<?php echo e(route('job-applications.index')); ?>" class="row g-2 align-items-end" style="padding:16px">
        <div class="col-md-5">
            <label style="font-size:12px;font-weight:600;color:#6b7280">البحث</label>
            <input type="text" name="search" class="form-control" placeholder="اسم، جوال، هوية..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <label style="font-size:12px;font-weight:600;color:#6b7280">الحالة</label>
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">الكل</option>
                <option value="pending"  <?php echo e(request('status') == 'pending'   ? 'selected' : ''); ?>>معلق</option>
                <option value="reviewed" <?php echo e(request('status') == 'reviewed'  ? 'selected' : ''); ?>>تمت المراجعة</option>
                <option value="accepted" <?php echo e(request('status') == 'accepted'  ? 'selected' : ''); ?>>مقبول</option>
                <option value="rejected" <?php echo e(request('status') == 'rejected'  ? 'selected' : ''); ?>>مرفوض</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-save w-100" style="font-size:13px">
                <i class="bi bi-search"></i> بحث
            </button>
        </div>
        <?php if(request()->hasAny(['search','status'])): ?>
        <div class="col-md-2">
            <a href="<?php echo e(route('job-applications.index')); ?>" class="btn btn-back w-100" style="font-size:13px">مسح</a>
        </div>
        <?php endif; ?>
    </form>
</div>


<div class="card">
    <div class="card-body p-0">
        <?php if($applications->count() > 0): ?>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>المتقدم</th>
                    <th>الجوال</th>
                    <th>الوظيفة المطلوبة</th>
                    <th>المؤهل</th>
                    <th>الخبرة</th>
                    <th>الحالة</th>
                    <th>تاريخ التقديم</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:38px;height:38px;border-radius:50%;background:#1a1a2e;flex-shrink:0;overflow:hidden;display:flex;align-items:center;justify-content:center">
                                <?php if($app->photo): ?>
                                    <img src="<?php echo e(Storage::disk('public')->url($app->photo)); ?>" style="width:38px;height:38px;object-fit:cover">
                                <?php else: ?>
                                    <span style="color:white;font-weight:700;font-size:14px"><?php echo e(mb_substr($app->full_name,0,1)); ?></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:14px"><?php echo e($app->full_name); ?></div>
                                <div style="font-size:11px;color:#9ca3af;font-family:monospace"><?php echo e($app->id_number); ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px"><?php echo e($app->phone); ?></td>
                    <td style="font-size:13px"><?php echo e($app->desired_position); ?></td>
                    <td style="font-size:13px"><?php echo e($app->education_level ?? '-'); ?></td>
                    <td style="font-size:13px">
                        <?php
                            $expLabels = ['0'=>'بدون', '1'=>'أقل من سنة', '2'=>'1-2', '3'=>'3-5', '4'=>'6-10', '5'=>'+10'];
                        ?>
                        <?php echo e($expLabels[$app->experience_years] ?? ($app->experience_years ?? '-')); ?>

                    </td>
                    <td>
                        <span style="background:<?php echo e($app->status_bg); ?>;color:<?php echo e($app->status_color); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($app->status_label); ?>

                        </span>
                    </td>
                    <td style="font-size:12px;color:#6b7280"><?php echo e($app->created_at->format('Y-m-d')); ?></td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('job-applications.show', $app->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if($app->status === 'accepted'): ?>
                            <a href="<?php echo e(route('job-applications.convert', $app->id)); ?>" class="btn btn-save" style="font-size:11px;padding:4px 8px;background:#16a34a">
                                <i class="bi bi-person-plus"></i>
                            </a>
                            <?php endif; ?>
                            <form action="<?php echo e(route('job-applications.destroy', $app->id)); ?>" method="POST" onsubmit="return confirm('حذف هذا الطلب؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:16px 20px">
            <?php echo e($applications->withQueryString()->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-people" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد طلبات توظيف</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/job-applications/index.blade.php ENDPATH**/ ?>