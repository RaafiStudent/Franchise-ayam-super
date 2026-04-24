<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function read($id)
    {
        // Cari notifikasi berdasarkan ID, lalu tandai sudah dibaca
        $notification = auth()->user()->unreadNotifications->where('id', $id)->first();
        
        if($notification) {
            $notification->markAsRead();
            // Arahkan user ke URL tujuan notifikasi tersebut
            return redirect($notification->data['url']);
        }

        return redirect()->back();
    }
}