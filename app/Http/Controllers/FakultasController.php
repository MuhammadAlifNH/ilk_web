<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FakultasController extends Controller
{
    public function index()
    {
        // Ambil data fakultas
        $fakultas = Fakultas::paginate(10); // misalnya 10 data per halaman

        return view('features.fakultas', compact('fakultas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
        ]);
    
        $fakultas = new Fakultas();
        $fakultas->nama_fakultas = $request->nama_fakultas;
        $fakultas->user_id = Auth::id();
        $fakultas->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Fakultas berhasil disimpan.',
            'data' => $fakultas
        ]);
    }
    


    public function destroy($id)
    {
        $fakultas = Fakultas::find($id);

        if (!$fakultas) {
            return redirect()->back()->with('error', 'Data fakultas tidak ditemukan');
        }

        try {
            $fakultas->delete();
            return redirect()->back()->with('success', 'Data fakultas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Terjadi kesalahan saat menghapus data fakultas');
        }
    }

    
}
