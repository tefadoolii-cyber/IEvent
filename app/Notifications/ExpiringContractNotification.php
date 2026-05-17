<?php

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Notifications\Notification;

class ExpiringContractNotification extends Notification
{
    public function __construct(public Contract $contract) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'expiring_contract',
            'title'   => 'عقد على وشك الانتهاء',
            'message' => "عقد الموظف {$this->contract->employee?->name} ينتهي بتاريخ {$this->contract->end_date}",
            'url'     => route('contracts.show', $this->contract->id),
        ];
    }
}
