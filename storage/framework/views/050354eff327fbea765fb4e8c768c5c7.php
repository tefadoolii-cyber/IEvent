<?php $__env->startSection('title', 'تفاصيل رخصة الجاهزية'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-shield-check"></i> رخصة الجاهزية — <?php echo e($readinessLicense->employee->name); ?></h4>
    <a href="<?php echo e(route('readiness-licenses.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<?php
    $lc=['active'=>'#16a34a','expired'=>'#d97706','withdrawn'=>'#dc2626'];
    $lb=['active'=>'#dcfce7','expired'=>'#fef3c7','withdrawn'=>'#fee2e2'];
?>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><span style="font-weight:600">بيانات الرخصة</span></div>
            <div class="card-body" style="padding:20px">
                <?php $__currentLoopData = [
                    ['icon'=>'bi-person',       'label'=>'الموظف',          'value'=>$readinessLicense->employee->name],
                    ['icon'=>'bi-calendar',     'label'=>'تاريخ الإصدار',  'value'=>$readinessLicense->issued_at->format('Y-m-d')],
                    ['icon'=>'bi-calendar-x',   'label'=>'تاريخ الانتهاء', 'value'=>$readinessLicense->expires_at?->format('Y-m-d') ?? 'دائمة'],
                    ['icon'=>'bi-person-check', 'label'=>'أصدرها',          'value'=>$readinessLicense->issuer->name],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi <?php echo e($r['icon']); ?>" style="color:#9ca3af;width:16px"></i>
                    <span style="color:#6b7280;flex:1"><?php echo e($r['label']); ?></span>
                    <span style="font-weight:600"><?php echo e($r['value']); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div style="margin-top:14px;text-align:center">
                    <span style="background:<?php echo e($lb[$readinessLicense->status]??'#f3f4f6'); ?>;color:<?php echo e($lc[$readinessLicense->status]??'#6b7280'); ?>;padding:6px 18px;border-radius:20px;font-size:13px;font-weight:700">
                        <?php echo e($readinessLicense->status_label); ?>

                    </span>
                </div>
                <?php if($readinessLicense->notes): ?>
                <div style="margin-top:14px;padding:12px;background:#f9fafb;border-radius:8px;font-size:13px;color:#374151"><?php echo e($readinessLicense->notes); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($readinessLicense->status === 'active'): ?>
    <div class="col-md-6">
        <div class="card" style="border:1px solid #fca5a5">
            <div class="card-header" style="background:#fee2e2"><span style="font-weight:600;color:#dc2626"><i class="bi bi-shield-x"></i> سحب الرخصة</span></div>
            <div class="card-body" style="padding:20px">
                <form action="<?php echo e(route('readiness-licenses.withdraw', $readinessLicense->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <label class="form-label" style="font-size:13px">سبب السحب *</label>
                    <textarea name="withdrawal_reason" class="form-control" rows="3" required placeholder="أدخل سبب سحب الرخصة..."></textarea>
                    <button type="submit" class="btn btn-delete mt-3 w-100" onclick="return confirm('سحب رخصة الجاهزية؟')">
                        <i class="bi bi-shield-x"></i> سحب الرخصة
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($readinessLicense->status === 'withdrawn'): ?>
    <div class="col-md-6">
        <div class="card" style="border:1px solid #fca5a5">
            <div class="card-header" style="background:#fee2e2"><span style="font-weight:600;color:#dc2626">بيانات السحب</span></div>
            <div class="card-body" style="padding:20px;font-size:13px">
                <p><strong>سُحبت بواسطة:</strong> <?php echo e($readinessLicense->withdrawer?->name); ?></p>
                <p><strong>تاريخ السحب:</strong> <?php echo e($readinessLicense->withdrawn_at?->format('Y-m-d H:i')); ?></p>
                <p><strong>السبب:</strong> <?php echo e($readinessLicense->withdrawal_reason); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/readiness-licenses/show.blade.php ENDPATH**/ ?>