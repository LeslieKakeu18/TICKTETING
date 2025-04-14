<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class TicketUpdated extends Notification
{
    use Queueable;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['database']; // on stocke dans la DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Le ticket '{$this->ticket->titre}' a été mis à jour par le technicien.",
            'ticket_id' => $this->ticket->id,
        ];
    }
}
