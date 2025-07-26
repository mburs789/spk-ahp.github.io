<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Menandai notifikasi sebagai dibaca
     */
    public function markAsRead($id)
    {
        // Temukan notifikasi berdasarkan ID dan tandai sebagai dibaca
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Notifikasi berhasil ditandai sebagai dibaca.');
    }

    /**
     * Menghapus notifikasi
     */
    public function delete($id)
    {
        // Temukan notifikasi berdasarkan ID dan hapus
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Notifikasi berhasil dihapus.');
    }
}
