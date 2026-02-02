<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewEmployeeNotification extends Notification
{
    use Queueable;

    public $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Database لتخزين الإشعار, Broadcast للRealtime
    }

    public function toArray($notifiable)
    {

 
return [
    'type' => 'employee',
    'title' => 'تم إضافة موظف جديد',
            'employee_name'  => $this->employee->full_name,
   // 'url' => route('employees.index'),
];

    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
