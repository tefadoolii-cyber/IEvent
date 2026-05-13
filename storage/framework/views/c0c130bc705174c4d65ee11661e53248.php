

<?php $__env->startSection('title', 'إعدادات النظام'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إعدادات النظام</h4>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<form action="<?php echo e(route('settings.update')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <?php
    $groupNames = [
        'branding' => 'الهوية البصرية',
        'theme'    => 'الألوان والمظهر',
        'general'  => 'معلومات عامة',
    ];
    $labels = [
        'platform_name_en'  => 'اسم المنصة (إنجليزي)',
        'platform_name_ar'  => 'اسم المنصة (عربي)',
        'platform_logo'     => 'شعار المنصة',
        'platform_favicon'  => 'أيقونة المتصفح',
        'primary_color'     => 'اللون الرئيسي',
        'sidebar_color'     => 'لون السايدبار',
        'background_color'  => 'لون الخلفية',
        'contact_email'     => 'البريد الإلكتروني',
        'contact_phone'     => 'رقم الجوال',
        'company_name'      => 'اسم الشركة',
    ];
    ?>

    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card mb-3">
        <div class="card-header">
            <span style="font-weight:600; font-size:15px"><?php echo e($groupNames[$group] ?? $group); ?></span>
        </div>
        <div class="card-body" style="padding:25px">
            <div class="row g-3">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                    <label class="form-label"><?php echo e($labels[$setting->key] ?? $setting->key); ?></label>

                    <?php if($setting->type == 'color'): ?>
                        <input type="color" name="settings[<?php echo e($setting->key); ?>]" value="<?php echo e($setting->value); ?>" class="form-control" style="height: 45px">
                    <?php elseif($setting->type == 'image'): ?>
                        <?php if($setting->value): ?>
                            <div class="mb-2">
                                <img src="<?php echo e(asset('storage/' . $setting->value)); ?>" style="max-height: 80px; border-radius: 8px">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="settings[<?php echo e($setting->key); ?>]" class="form-control">
                    <?php else: ?>
                        <input type="text" name="settings[<?php echo e($setting->key); ?>]" value="<?php echo e($setting->value); ?>" class="form-control">
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <button type="submit" class="btn btn-save">حفظ الإعدادات</button>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/settings/index.blade.php ENDPATH**/ ?>