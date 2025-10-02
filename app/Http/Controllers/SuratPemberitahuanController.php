<?php

namespace App\Http\Controllers;

use App\Models\SuratPemberitahuan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\SuratPemberitahuanNotification;
use PDF;

class SuratPemberitahuanController extends Controller
{
    public function index()
    {
        $surat = SuratPemberitahuan::latest()->get();
        return view('features.surat_pemberitahuan.index', compact('surat'));
    }

    public function create()
    {
        return view('features.surat_pemberitahuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'isi_surat' => 'required',
            'pengirim' => 'required'
        ]);

        $surat = SuratPemberitahuan::create($request->all());

        // Kirim notifikasi ke semua user
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new SuratPemberitahuanNotification($surat));
        }

        return redirect()->route('surat-pemberitahuan.index')->with('success', 'Surat berhasil dibuat dan notifikasi dikirim.');
    }

    public function show($id)
    {
        $surat = SuratPemberitahuan::findOrFail($id);

        // Tandai notifikasi sebagai dibaca
        foreach (auth()->user()->unreadNotifications as $notification) {
            if (($notification->data['id_surat'] ?? null) == $id) {
                $notification->markAsRead();
            }
        }

        return view('features.surat_pemberitahuan.show', compact('surat'));
    }

    public function cetak($id)
    {
        $surat = SuratPemberitahuan::findOrFail($id);
        $pdf = PDF::loadView('features.surat_pemberitahuan.cetak', compact('surat'));
        return $pdf->download('Surat_Pemberitahuan_'.$surat->id.'.pdf');
    }
}
