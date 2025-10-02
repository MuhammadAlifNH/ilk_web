<?php

use App\Http\Controllers\PeriksaKerasController;
use App\Http\Controllers\PeriksaLunakController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Fakultas;
use App\Models\Labs;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaboranController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TeknisiController;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\PerkerasController;
use App\Http\Controllers\PerlunakController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\SuratPemberitahuanController;
use App\Http\Controllers\PermohonanAplikasiController;
use App\Http\Controllers\SuratPeminjamanController;
use App\Http\Controllers\NotifikasiController;
use App\Models\PeriksaLunakDetail;
use App\Models\Perkeras;
use App\Models\Perlunak;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return redirect('/');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/get-fakultas', function () {
    return response()->json(Fakultas::all());
});

Route::get('/get-labs/{fakultas_id}', function ($fakultas_id) {
    return response()->json(Labs::where('fakultas_id', $fakultas_id)->get());
});

Route::get('/get-keras/{labId}', function ($labId) {
    $lab = Labs::find($labId);
    $perkeras = Perkeras::where('lab_id', $labId)->get(['id', 'nama']);

    return response()->json([
        'jumlah_meja' => $lab ? $lab->jumlah_meja : 0,
        'nama' => $perkeras
    ]);
});

Route::get('/get-lunak/{labId}', function ($labId) {
    $lab = Labs::find($labId);
    $perlunak = Perlunak::where('lab_id', $labId)->get(['id', 'nama']);

    return response()->json([
        'jumlah_meja' => $lab ? $lab->jumlah_meja : 0,
        'nama' => $perlunak
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{id}', [NotifikasiController::class, 'show'])->name('notifikasi.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
    
    Route::resource('fakultas', FakultasController::class);
    
    Route::resource('users', UsersController::class);
    Route::put('/users/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        request()->validate(['role' => 'required|string']);
        $user->update(['role' => request('role')]);
        return response()->json(['success' => true]);
    })->name('users.update'); 
    
    Route::resource('labs', LabController::class);

    Route::resource('perlunak', PerlunakController::class);

    Route::resource('perkeras', PerkerasController::class);

    Route::resource('jadwal', JadwalController::class);

    Route::resource('inventaris', InventarisController::class);

    Route::get('/inventaris/download/{id}', [InventarisController::class, 'download'])->name('inventaris.download');

    Route::resource('periksa_keras', PeriksaKerasController::class);

    Route::get('/periksa-keras/{id}/download', [PeriksaKerasController::class, 'download'])->name('periksa_keras.download');

    Route::resource('periksa_lunak', PeriksaLunakController::class);

    Route::get('/periksa-lunak/{id}/download', [PeriksaLunakDetail::class, 'download'])->name('periksa_lunak.download');

    Route::resource('surat-pemberitahuan', SuratPemberitahuanController::class);
    Route::get('/surat-pemberitahuan/{id}/cetak', [SuratPemberitahuanController::class, 'cetak'])->name('surat-pemberitahuan.cetak');

    // Permohonan Aplikasi - Admin
    Route::get('/permohonan-aplikasi', [PermohonanAplikasiController::class, 'index'])
        ->name('admin.permohonan-aplikasi.index');
    Route::get('/permohonan-aplikasi/{id}/balas', [PermohonanAplikasiController::class, 'balas'])
        ->name('permohonan-aplikasi.balas');
    Route::post('/permohonan-aplikasi/{id}/balas', [PermohonanAplikasiController::class, 'kirimBalasan'])
        ->name('permohonan-aplikasi.kirim-balasan');
    Route::get('/permohonan-aplikasi/{id}/cetak-balasan', [PermohonanAplikasiController::class, 'cetakBalasan'])
        ->name('permohonan-aplikasi.cetak-balasan');

    Route::get('admin/peminjaman', [SuratPeminjamanController::class,'adminIndex'])->name('admin.peminjaman.index');
    Route::post('admin/peminjaman/{id}/approve', [SuratPeminjamanController::class,'approve'])->name('admin.peminjaman.approve');
    Route::post('admin/peminjaman/{id}/reject', [SuratPeminjamanController::class,'reject'])->name('admin.peminjaman.reject');
    Route::get('admin/peminjaman/cetak', [SuratPeminjamanController::class,'cetak'])->name('admin.peminjaman.cetak');

});

Route::middleware(['auth', 'teknisi'])->group(function () {
    Route::get('/teknisi',[TeknisiController::class,'index'])->name('teknisi.index');

    // Permohonan Aplikasi - User
    Route::get('/permohonan-aplikasi/saya', [PermohonanAplikasiController::class, 'myIndex'])
        ->name('permohonan-aplikasi.saya');
    Route::get('/permohonan-aplikasi/create', [PermohonanAplikasiController::class, 'create'])
        ->name('permohonan-aplikasi.create');
    Route::post('/permohonan-aplikasi', [PermohonanAplikasiController::class, 'store'])
        ->name('permohonan-aplikasi.store');
    Route::get('/permohonan-aplikasi/{id}', [PermohonanAplikasiController::class, 'show'])
        ->name('permohonan-aplikasi.show');
    Route::get('/permohonan-aplikasi/{id}/cetak', [PermohonanAplikasiController::class, 'cetakPermohonan'])
        ->name('permohonan-aplikasi.cetak');

});

Route::middleware(['auth', 'laboran'])->group(function () {
    Route::get('/laboran',[LaboranController::class,'index'])->name('laboran.index');
        // Permohonan Aplikasi - User
    Route::get('/permohonan-aplikasi/saya', [PermohonanAplikasiController::class, 'myIndex'])
        ->name('permohonan-aplikasi.saya');
    Route::get('/permohonan-aplikasi/create', [PermohonanAplikasiController::class, 'create'])
        ->name('permohonan-aplikasi.create');
    Route::post('/permohonan-aplikasi', [PermohonanAplikasiController::class, 'store'])
        ->name('permohonan-aplikasi.store');
    Route::get('/permohonan-aplikasi/{id}', [PermohonanAplikasiController::class, 'show'])
        ->name('permohonan-aplikasi.show');
    Route::get('/permohonan-aplikasi/{id}/cetak', [PermohonanAplikasiController::class, 'cetakPermohonan'])
        ->name('permohonan-aplikasi.cetak');
});

Route::middleware(['auth', 'pengguna'])->group(function () {
    Route::get('/pengguna',[PenggunaController::class,'index'])->name('pengguna.index');
        // Permohonan Aplikasi - User
    Route::get('/permohonan-aplikasi/saya', [PermohonanAplikasiController::class, 'myIndex'])
        ->name('permohonan-aplikasi.saya');
    Route::get('/permohonan-aplikasi/create', [PermohonanAplikasiController::class, 'create'])
        ->name('permohonan-aplikasi.create');
    Route::post('/permohonan-aplikasi', [PermohonanAplikasiController::class, 'store'])
        ->name('permohonan-aplikasi.store');
    Route::get('/permohonan-aplikasi/{id}', [PermohonanAplikasiController::class, 'show'])
        ->name('permohonan-aplikasi.show');
    Route::get('/permohonan-aplikasi/{id}/cetak', [PermohonanAplikasiController::class, 'cetakPermohonan'])
        ->name('permohonan-aplikasi.cetak');

    Route::get('peminjaman', [SuratPeminjamanController::class,'index'])->name('peminjaman.index');
    Route::get('peminjaman/create', [SuratPeminjamanController::class,'create'])->name('peminjaman.create');
    Route::post('peminjaman', [SuratPeminjamanController::class,'store'])->name('peminjaman.store');
});

require __DIR__.'/auth.php';


