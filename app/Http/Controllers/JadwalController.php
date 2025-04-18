<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        $jadwal = Jadwal::with('lab.fakultas', 'user')->get();
        return view('features.jadwal.add', compact('jadwal', 'fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'lab_id'      => 'required|exists:labs,id',
            'jadwal'      => 'required|mimes:jpg,jpeg,png,pdf|max:2048' // file gambar dan PDF, max 2MB
        ]);
    
        try {
            // Simpan file ke storage/public/jadwal
            $fileName = time() . '.' . $request->jadwal->extension();
            $filePath = $request->jadwal->storeAs('jadwal', $fileName, 'public');
    
            $jadwal = new Jadwal();
            $jadwal->fakultas_id = $request->fakultas_id;
            $jadwal->lab_id = $request->lab_id;
            $jadwal->jadwal = $filePath; // Simpan path file ke database
            $jadwal->user_id = Auth::id();
            $jadwal->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil ditambahkan',
                'file_path' => asset("storage/$filePath")
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }
    


    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Data jadwal tidak ditemukan');
        }

        try {
            // Hapus file jadwal dari storage
            Storage::disk('public')->delete($jadwal->jadwal);
            $jadwal->delete();
            return redirect()->back()->with('success', 'Data jadwal berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Terjadi kesalahan saat menghapus data jadwal');
        }
    }
}
