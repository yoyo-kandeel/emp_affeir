<?php

// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NotificationController extends Controller
{
    public function readAll()
    {
        Auth::user()->unreadNotifications->each->markAsRead();
        return back();
    }

    public function read($id)
    {
        $notification = Auth::user()
            ->notifications
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }
public function via()
{
    return ['database', 'broadcast'];
}

public function toBroadcast()
{
    return new BroadcastMessage([
        'title'   => 'تم إضافة موظف جديد',
        'message' => 'تم إضافة موظف جديد إلى النظام بنجاح',
    ]);
}

}
