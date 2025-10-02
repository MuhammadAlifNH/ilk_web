<?php

namespace App\Http\Controllers;

use App\Models\SuratPeminjaman;
use App\Models\Lab;
use Illuminate\Http\Request;
use PDF;

class SuratPeminjamanController extends Controller
{
    public function index()
    {
        $items = SuratPeminjaman::where('user_id', auth()->id())->latest()->get();
        return view('features.surat_peminjaman.index', compact('items'));
    }

    public function create()
    {
        $labs = Lab::all();
        return view('features.surat_peminjaman.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lab_id' => 'required',
            'uraian' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        SuratPeminjaman::create([
            'user_id' => auth()->id(),
            'lab_id' => $request->lab_id,
            'instansi' => $request->instansi,
            'no_telp' => $request->no_telp,
            'uraian' => $request->uraian,
            'jumlah_orang' => $request->jumlah_orang,
            'lama_pinjam' => $request->lama_pinjam,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Permohonan peminjaman berhasil diajukan');
    }

    public function adminIndex()
    {
        $items = SuratPeminjaman::with('pemohon','lab')->latest()->get();
        return view('features.surat_peminjaman.admin_index', compact('items'));
    }

    public function approve($id)
    {
        $item = SuratPeminjaman::findOrFail($id);
        $item->update(['status' => 'disetujui']);
        return back()->with('success', 'Permohonan disetujui');
    }

    public function reject($id)
    {
        $item = SuratPeminjaman::findOrFail($id);
        $item->update(['status' => 'ditolak']);
        return back()->with('success', 'Permohonan ditolak');
    }

    public function cetak()
    {
        $items = SuratPeminjaman::with('pemohon','lab')->get();
        $pdf = PDF::loadView('features.surat_peminjaman.cetak', compact('items'));
        return $pdf->download('Buku_Peminjaman_Lab.pdf');
    }
}
