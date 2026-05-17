<?php

namespace App\Notifications;

use App\Models\SupportTicket;
use Illuminate\Notifications\Notification;

class NewSupportTicketNotification extends Notification
{
    public function __construct(public SupportTicket $ticket) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'new_ticket',
            'title'   => 'طلب دعم جديد',
            'message' => "طلب دعم جديد: \"{$this->ticket->title}\"",
            'url'     => route('support-tickets.show', $this->ticket->id),
        ];
    }
}
