<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perlunak;
use Illuminate\Support\Facades\Auth;
use App\Models\Fakultas;

class PerlunakController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        $perlunak = Perlunak::with('lab.fakultas', 'user')->get();
        return view('features.perlunak', compact('perlunak', 'fakultas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'lab_id' => 'required|exists:labs,id',
            'nama' => 'required|string|max:255',
        ]);

        try {
            $perlunak = new Perlunak();
            $perlunak->fakultas_id = $request->fakultas_id;
            $perlunak->lab_id = $request->lab_id;
            $perlunak->nama = $request->nama;
            $perlunak->user_id = Auth::id();
            $perlunak->save();

            return response()->json(['success' => true, 'message' => 'Perangkat lunak berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }        
    }

    public function destroy($id)
    {
        $perlunak = Perlunak::find($id);

        if (!$perlunak) {
            return redirect()->back()->with('error', 'Data perangkat lunak tidak ditemukan');
        }

        try {
            $perlunak->delete();
            return redirect()->back()->with('success', 'Data perangkat lunak berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Terjadi kesalahan saat menghapus data perangkat lunak');
        }
    }
}
