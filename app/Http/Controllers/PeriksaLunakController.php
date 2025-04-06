<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Labs;
use App\Models\PeriksaLunak;
use App\Models\PeriksaLunakDetail;
use App\Models\Perlunak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaLunakController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        $perilunak = PeriksaLunak::with('lab.fakultas', 'user')->get();
        return view('features.pemeriksaan.periksa_lunak.index', compact('perilunak', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $labs = Labs::all();
        $perlunak = Perlunak::all();
        return view('features.pemeriksaan.periksa_lunak.create', compact('fakultas', 'labs', 'perlunak'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'lab_id' => 'required|exists:labs,id',
            'tanggal' => 'required|date',
            'fungsi' => 'required|array',
            'keterangan' => 'required|array',
        ]);

        try {
            // Simpan data utama
            $perilunak = PeriksaLunak::create([
                'fakultas_id' => $request->fakultas_id,
                'lab_id' => $request->lab_id,
                'user_id' => Auth::id(),
                'tanggal' => $request->tanggal,
            ]);

            // Ambil daftar perangkat di lab tersebut
            $lab = Labs::with('perlunak')->findOrFail($request->lab_id);
            $perangkat = $lab->perlunak;

            // Loop data sesuai baris meja
            foreach ($request->fungsi as $mejaIndex => $fungsiRow) {
                foreach ($fungsiRow as $perangkatIndex => $fungsiValue) {
                    $keteranganValue = $request->keterangan[$mejaIndex] ?? null;
                    $perangkatId = $perangkat[$perangkatIndex]->id ?? null;
            
                    if ($perangkatId) {
                        PeriksaLunakDetail::create([
                            'periksa_lunak_id' => $perilunak->id,
                            'perlunak_id' => $perangkatId,
                            'meja_ke' => $mejaIndex,
                            'kondisi_fungsional' => $fungsiValue,
                            'keterangan' => $keteranganValue,
                        ]);
                    }
                }
            }
            

            return redirect()->route('periksa_lunak.index')->with('success', 'Data pemeriksaan berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $periksa_lunak = PeriksaLunak::findOrFail($id)->load(['lab', 'fakultas', 'details.perangkat']);

        $perangkat = $periksa_lunak->details
            ->pluck('perangkat')
            ->unique('id')
            ->values();

        return view('features.pemeriksaan.periksa_lunak.show', compact('periksa_lunak', 'perangkat'));
    }


    
    

    public function destroy($id)
    {
        $perilunak = PeriksaLunak::findOrFail($id);
        $perilunak->delete();

        return redirect()->route('periksa_lunak.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
    

}
