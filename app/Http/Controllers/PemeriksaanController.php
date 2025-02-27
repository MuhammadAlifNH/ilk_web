<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Labs;
use App\Models\Pemriksaan;
use App\Models\RinciKeras;
use App\Models\RinciLunak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        $pemeriksaan = Pemriksaan::with('lab.fakultas', 'user')->get();
        return view('features.pemriksaan.index');
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $labs = Labs::all();
        return view('features.pemriksaan.create', compact('fakultas', 'labs'));
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
            // Simpan data utama ke tabel pemriksaan
            $pemeriksaan = Pemriksaan::create([
                'jenis' => $request->jenis,
                'tanggal' => $request->tanggal,
                'fakultas_id' => $request->fakultas_id,
                'lab_id' => $request->lab_id,
                'user_id' =>Auth::id(), // Simpan ID pengguna yang menambahkan
            ]);

            
            switch ($request->jenis) {
                case 'Perangkat Keras':
                    foreach ($request->perkeras as $kerasen) {
                        RinciKeras::create([
                            'pemeriksaan_id' => $pemeriksaan->id, // Hubungkan dengan pemriksaan_id
                            'keras_id' => $kerasen['keras_id'],
                            'kondisi_fisik' => $kerasen['kondisi_fisik'],
                            'kondisi_fungsional' => $kerasen['kondisi_fungsional'],
                            'keterangan' => $kerasen['keterangan'],
                        ]);
                    }
                    break;
                case 'Perangkat Lunak':
                    foreach ($request->perlunak as $lunaken) {
                        RinciLunak::create([
                            'pemeriksaan_id' => $pemeriksaan->id, // Hubungkan dengan pemriksaan_id
                            'lunak_id' => $lunaken['lunak_id'],
                            'kondisi' => $lunaken['kondisi'],
                            'keterangan' => $lunaken['keterangan'],
                        ]);
                    }
                    break;
            }

            return redirect()->route('pemriksaan.index')->with('success', 'Berhasil menambahkan data pemriksaan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data pemriksaan');
        }
    }

    public function show($id)
    {
        $pemeriksaan = Pemriksaan::with('lab.fakultas', 'user')->find($id);
        if (!$pemeriksaan) {
            return redirect()->route('pemriksaan.index')->with('error', 'Data tidak ditemukan');
        }
        return view('features.pemriksaan.show', compact('pemeriksaan'));
    }

    public function destroy($id)
    {
        $pemeriksaan = Pemriksaan::find($id);
        if (!$pemeriksaan) {
            return redirect()->route('pemeriksaan.index')->with('error', 'Data tidak ditemukan');
        }
        $pemeriksaan->delete();
        return redirect()->route('pemriksaan.index')->with('success', 'Berhasil menghapus data pemriksaan');
    }
}
