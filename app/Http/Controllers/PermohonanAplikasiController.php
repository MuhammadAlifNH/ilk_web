<?php

namespace App\Http\Controllers;

use App\Models\PermohonanAplikasi;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\PermohonanAplikasiBaruNotification;
use App\Notifications\PermohonanAplikasiDibalasNotification;
use PDF;

class PermohonanAplikasiController extends Controller
{
    // USER: daftar permohonan milik sendiri
    public function myIndex()
    {
        $items = PermohonanAplikasi::where('user_id', auth()->id())->latest()->paginate(10);
        return view('features.surat_permohonan_aplikasi.index', compact('items'));
    }

    // USER: tampilkan form
    public function create()
    {
        return view('features.surat_permohonan_aplikasi.create');
    }

    // USER: simpan permohonan
    public function store(Request $request)
    {
        $data = $request->validate([
            'program_studi'   => 'required|string|max:150',
            'fakultas'        => 'required|string|max:150',
            'software'        => 'required|array|min:1',
            'software.*.nama' => 'required|string|max:150',
            'software.*.versi' => 'nullable|string|max:100',
            'software.*.lisensi' => 'nullable|integer',
            'software.*.mahasiswa' => 'nullable|integer',
            'tgl_dibutuhkan'  => 'nullable|date',
            'alasan'          => 'required|string',
        ]);

        $permohonan = PermohonanAplikasi::create([
            'user_id'        => auth()->id(),
            'program_studi'  => $data['program_studi'],
            'fakultas'       => $data['fakultas'],
            'daftar_software'=> $data['software'], // simpan dalam JSON
            'tgl_dibutuhkan' => $data['tgl_dibutuhkan'] ?? null,
            'alasan'         => $data['alasan'],
        ]);

        // kirim notifikasi ke admin
        $admins = User::where('role','admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new PermohonanAplikasiBaruNotification($permohonan));
        }

        return redirect()->route('permohonan-aplikasi.saya')
                         ->with('success','Permohonan berhasil dikirim.');
    }

    // DETAIL: user bisa lihat miliknya, admin bisa lihat semua
    public function show($id)
    {
        $item = PermohonanAplikasi::with(['pemohon','adminBalas'])->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $item->user_id !== auth()->id()) {
            abort(403);
        }

        // tandai notifikasi terkait sebagai read
        foreach (auth()->user()->unreadNotifications as $n) {
            if (($n->data['id_permohonan'] ?? null) == $item->id) $n->markAsRead();
        }

        return view('features.surat_permohonan_aplikasi.show', compact('item'));
    }

    // ADMIN: daftar semua permohonan
    public function index()
    {
        $items = PermohonanAplikasi::with('pemohon')->latest()->paginate(15);
        return view('features.surat_permohonan_aplikasi.admin_index', compact('items'));
    }

    // ADMIN: form balas
    public function balas($id)
    {
        $item = PermohonanAplikasi::findOrFail($id);
        return view('features.surat_permohonan_aplikasi.balas', compact('item'));
    }

    // ADMIN: simpan balasan
    public function kirimBalasan($id, Request $request)
    {
        $item = PermohonanAplikasi::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:diproses,disetujui,ditolak',
            'isi_balasan' => 'required|string',
            'nomor_surat_balasan' => 'nullable|string|max:100',
            'tanggal_balasan' => 'nullable|date',
        ]);

        $item->update(array_merge($data, [
            'admin_id' => auth()->id(),
        ]));

        // notifikasi ke pemohon
        $item->pemohon->notify(new PermohonanAplikasiDibalasNotification($item));

        return redirect()->route('admin.permohonan-aplikasi.index')
                         ->with('success','Balasan berhasil dikirim.');
    }

    // CETAK PDF: permohonan (FM-Lab-02-01)
    public function cetakPermohonan($id)
    {
        $item = PermohonanAplikasi::findOrFail($id);
        $pdf = PDF::loadView('features.surat_permohonan_aplikasi.cetak_permohonan', compact('item'));
        return $pdf->download('Permohonan_Software_'.$item->id.'.pdf');
    }

    // CETAK PDF: balasan (FM-Lab-02-03)
    public function cetakBalasan($id)
    {
        $item = PermohonanAplikasi::findOrFail($id);
        $pdf = PDF::loadView('features.surat_permohonan_aplikasi.cetak_balasan', compact('item'));
        return $pdf->download('Balasan_Permohonan_Software_'.$item->id.'.pdf');
    }
}
