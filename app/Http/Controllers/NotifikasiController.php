<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->paginate(10);
        return view('features.notifikasi.index', compact('notifications'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->findOrFail($id);

        // tandai sebagai dibaca
        if ($notification->unread()) {
            $notification->markAsRead();
        }

        // jika notifikasi punya link ke surat pemberitahuan
        if (isset($notification->data['id_surat'])) {
            return redirect()->route('surat-pemberitahuan.show', $notification->data['id_surat']);
        }

        return back();
    }
}
