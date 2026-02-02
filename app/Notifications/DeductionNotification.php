<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class DeductionNotification extends Notification
{
    
    use Queueable;

    public $deduction;

    public function __construct($deduction)
    {
        $this->deduction = $deduction;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; 
    }

    public function toArray($notifiable)
    {
       return [
    'type' => 'deduction',
    'title' => 'تم إضافة خصم جديد',
    'employee_name' => $this->deduction->emp_data->full_name,
    'quantity' => $this->deduction->quantity,
    //'url' => route('emp_deductions.index'),
];

    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}