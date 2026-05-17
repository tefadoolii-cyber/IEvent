<?php $__env->startSection('title', 'إدارة الأحداث'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-calendar-event"></i> إدارة الأحداث</h4>
    <a href="<?php echo e(route('events.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> حدث جديد
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>


<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px">
            <div style="font-size:26px;font-weight:800;color:#374151"><?php echo e($stats['total']); ?></div>
            <div style="font-size:12px;color:#9ca3af">إجمالي الأحداث</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px;border-right:4px solid #d97706">
            <div style="font-size:26px;font-weight:800;color:#d97706"><?php echo e($stats['planning']); ?></div>
            <div style="font-size:12px;color:#9ca3af">تخطيط</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px;border-right:4px solid #2563eb">
            <div style="font-size:26px;font-weight:800;color:#2563eb"><?php echo e($stats['active']); ?></div>
            <div style="font-size:12px;color:#9ca3af">نشط</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px 12px;border-right:4px solid #16a34a">
            <div style="font-size:26px;font-weight:800;color:#16a34a"><?php echo e($stats['completed']); ?></div>
            <div style="font-size:12px;color:#9ca3af">مكتمل</div>
        </div>
    </div>
</div>


<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="بحث بالاسم..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="planning"  <?php echo e(request('status')=='planning'  ? 'selected':''); ?>>تخطيط</option>
                <option value="active"    <?php echo e(request('status')=='active'    ? 'selected':''); ?>>نشط</option>
                <option value="completed" <?php echo e(request('status')=='completed' ? 'selected':''); ?>>مكتمل</option>
                <option value="cancelled" <?php echo e(request('status')=='cancelled' ? 'selected':''); ?>>ملغي</option>
            </select>
        </div>
        <?php if($eventTypes->count()): ?>
        <div class="col-md-3">
            <select name="type" class="form-select" style="font-size:13px">
                <option value="">كل الأنواع</option>
                <?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t->value_ar); ?>" <?php echo e(request('type')==$t->value_ar ? 'selected':''); ?>><?php echo e($t->value_ar); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php endif; ?>
        <div class="col-md-2">
            <button type="submit" class="btn btn-save w-100" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        <?php if(request()->hasAny(['search','status','type'])): ?>
        <div class="col-auto">
            <a href="<?php echo e(route('events.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a>
        </div>
        <?php endif; ?>
    </form>
</div>


<div class="card">
    <div class="card-body p-0">
        <?php if($events->count()): ?>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>اسم الحدث</th>
                    <th>النوع</th>
                    <th>تاريخ البدء</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الموقع</th>
                    <th>المدير</th>
                    <th>الميزانية</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="font-weight:600"><?php echo e($event->name); ?></div>
                        <?php if($event->description): ?>
                            <div style="font-size:11px;color:#9ca3af"><?php echo e(Str::limit($event->description, 50)); ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px"><?php echo e($event->type ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($event->start_date->format('Y-m-d')); ?></td>
                    <td style="font-size:13px"><?php echo e($event->end_date?->format('Y-m-d') ?? 'مفتوح'); ?></td>
                    <td style="font-size:13px"><?php echo e($event->location?->name ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($event->manager?->name ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($event->budget ? number_format($event->budget,0).' ر.س' : '-'); ?></td>
                    <td>
                        <span style="background:<?php echo e($event->status_bg); ?>;color:<?php echo e($event->status_color); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($event->status_label); ?>

                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('events.show', $event->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('events.edit', $event->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('events.destroy', $event->id)); ?>" method="POST" onsubmit="return confirm('حذف هذا الحدث؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($events->withQueryString()->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-calendar-x" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد أحداث</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/events/index.blade.php ENDPATH**/ ?>