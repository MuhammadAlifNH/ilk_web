<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Labs;
use App\Models\Pemeriksaan;
use App\Models\RincianKeras;
use App\Models\RincianLunak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        $pemeriksaan = Pemeriksaan::with('lab.fakultas', 'user')->get();
        return view('features.pemeriksaan.index', compact('pemeriksaan', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $labs = Labs::all();
        return view('features.pemeriksaan.create', compact('fakultas', 'labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'fakultas_id' => 'required|exists:fakultas,id',
            'lab_id' => 'required|exists:labs,id',
            'tanggal' => 'required|date',
            'perkeras' => 'required_if:jenis,Perangkat Keras|array',
            'perlunak' => 'required_if:jenis,Perangkat Lunak|array',
        ]);

        try {
            // Simpan data utama ke tabel pemeriksaan
            $pemeriksaan = Pemeriksaan::create([
                'jenis' => $request->jenis,
                'tanggal' => $request->tanggal,
                'fakultas_id' => $request->fakultas_id,
                'lab_id' => $request->lab_id,
                'user_id' =>Auth::id(), // Simpan ID pengguna yang menambahkan
            ]);

            
            switch ($request->jenis) {
                case 'Perangkat Keras':
                    foreach ($request->perkeras as $kerasen) {
                        RincianKeras::create([
                            'pemeriksaan_id' => $pemeriksaan->id, // Hubungkan dengan pemeriksaan_id
                            'keras_id' => $kerasen['keras_id'],
                            'kondisi_fisik' => $kerasen['kondisi_fisik'],
                            'kondisi_fungsional' => $kerasen['kondisi_fungsional'],
                            'keterangan' => $kerasen['keterangan'],
                        ]);
                    }
                    break;
                case 'Perangkat Lunak':
                    foreach ($request->perlunak as $lunaken) {
                        RincianLunak::create([
                            'pemeriksaan_id' => $pemeriksaan->id, // Hubungkan dengan pemeriksaan_id
                            'lunak_id' => $lunaken['lunak_id'],
                            'kondisi' => $lunaken['kondisi'],
                            'keterangan' => $lunaken['keterangan'],
                        ]);
                    }
                    break;
            }

            return redirect()->route('pemeriksaan.index')->with('success', 'Berhasil menambahkan data pemeriksaan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data pemeriksaan');
        }
    }

    public function show($id)
    {
        $pemeriksaan = Pemeriksaan::with('lab.fakultas', 'user')->find($id);
        if (!$pemeriksaan) {
            return redirect()->route('pemeriksaan.index')->with('error', 'Data tidak ditemukan');
        }
        return view('features.pemeriksaan.show', compact('pemeriksaan'));
    }

    public function destroy($id)
    {
        $pemeriksaan = Pemeriksaan::find($id);
        if (!$pemeriksaan) {
            return redirect()->route('pemeriksaan.index')->with('error', 'Data tidak ditemukan');
        }
        $pemeriksaan->delete();
        return redirect()->route('pemeriksaan.index')->with('success', 'Berhasil menghapus data pemeriksaan');
    }
}
