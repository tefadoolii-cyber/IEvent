<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Notifications\Notification;

class LateTaskNotification extends Notification
{
    public function __construct(public Task $task) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'late_task',
            'title'   => 'مهمة متأخرة',
            'message' => "المهمة \"{$this->task->title}\" للموظف {$this->task->employee?->name} لم تُنجز في موعدها",
            'url'     => route('tasks.index'),
        ];
    }
}
