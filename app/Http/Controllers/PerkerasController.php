<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkeras;
use Illuminate\Support\Facades\Auth;
use App\Models\Fakultas;


class PerkerasController extends Controller
{
    public function index()
    {
        
        $fakultas = Fakultas::all();
        $perkeras = Perkeras::with('lab.fakultas', 'user')->get();
        return view('features.perkeras', compact('perkeras', 'fakultas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'lab_id' => 'required|exists:labs,id',
            'nama' => 'required|string|max:255',
        ]);

        try {
            $perkeras = new Perkeras();
            $perkeras->fakultas_id = $request->fakultas_id;
            $perkeras->lab_id = $request->lab_id;
            $perkeras->nama = $request->nama;
            $perkeras->user_id = Auth::id();
            $perkeras->save();

            return response()->json(['success' => true, 'message' => 'Perkeras berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }        
    }

    public function destroy($id)
    {
        $perkeras = Perkeras::find($id);

        if (!$perkeras) {
            return redirect()->back()->with('error', 'Data peralatan keras tidak ditemukan');
        }

        try {
            $perkeras->delete();
            return redirect()->back()->with('success', 'Data peralatan keras berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Terjadi kesalahan saat menghapus data peralatan keras');
        }
    }
}
