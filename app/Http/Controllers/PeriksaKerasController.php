<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Labs;
use App\Models\PeriksaKeras;
use App\Models\PeriksaKerasDetail;
use App\Models\Perkeras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaKerasController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        $perikeras = PeriksaKeras::with('lab.fakultas', 'user')->get();
        return view('features.pemeriksaan.periksa_keras.index', compact('perikeras', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $labs = Labs::all();
        $perkeras = Perkeras::all();
        return view('features.pemeriksaan.periksa_keras.create', compact('fakultas', 'labs', 'perkeras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'lab_id' => 'required|exists:labs,id',
            'tanggal' => 'required|date',
            'fisik' => 'required|array',
            'fungsi' => 'required|array',
            'keterangan' => 'required|array',
        ]);

        try {
            // Simpan data utama
            $perikeras = PeriksaKeras::create([
                'fakultas_id' => $request->fakultas_id,
                'lab_id' => $request->lab_id,
                'user_id' => Auth::id(),
                'tanggal' => $request->tanggal,
            ]);

            // Ambil daftar perangkat di lab tersebut
            $lab = Labs::with('perkeras')->findOrFail($request->lab_id);
            $perangkat = $lab->perkeras;

            // Loop data sesuai baris meja
            foreach ($request->fisik as $mejaIndex => $fisikRow) {
                foreach ($fisikRow as $perangkatIndex => $fisikValue) {
                    $fungsiValue = $request->fungsi[$mejaIndex][$perangkatIndex] ?? null;
                    $keteranganValue = $request->keterangan[$mejaIndex] ?? null;

                    $perangkatId = $perangkat[$perangkatIndex]->id ?? null;

                    if ($perangkatId) {
                        PeriksaKerasDetail::create([
                            'periksa_keras_id' => $perikeras->id,
                            'perkeras_id' => $perangkatId,
                            'meja_ke' => $mejaIndex,
                            'kondisi_fisik' => $fisikValue,
                            'kondisi_fungsional' => $fungsiValue,
                            'keterangan' => $keteranganValue,
                        ]);
                    }
                }
            }

            return redirect()->route('periksa_keras.index')->with('success', 'Data pemeriksaan berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $periksa_keras = PeriksaKeras::findOrFail($id)->load(['lab', 'fakultas', 'details.perangkat']);

        $perangkat = $periksa_keras->details
            ->pluck('perangkat')
            ->unique('id')
            ->values();

        return view('features.pemeriksaan.periksa_keras.show', compact('periksa_keras', 'perangkat'));
    }


    
    

    public function destroy($id)
    {
        $perikeras = PeriksaKeras::findOrFail($id);
        $perikeras->delete();

        return redirect()->route('periksa_keras.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
    

}
