<?php

use App\Http\Controllers\GaleriOrmawaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrmawaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LpjController;
use App\Http\Controllers\PrestasiOrmawaController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\ProposalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    
    // USER
    Route::delete('/user/destroyRole/{id}', [UserController::class, 'destroyRole'])->name('user.destroyRole');
    Route::get('/user/getOrmawa/{id}', [UserController::class, 'getOrmawa'])->name('user.getOrmawa');
    Route::patch('/user/resetPassword/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
    Route::get('/user/verifikasi/', [UserController::class, 'verifikasi'])->name('user.verifikasi');
    Route::patch('/user/verifikasiAnggota/{id}', [UserController::class, 'verifikasiAnggota'])->name('user.verifikasiAnggota');
    Route::patch('/user/verifikasiRegistrasi/{id}', [UserController::class, 'verifikasiRegistrasi'])->name('user.verifikasiRegistrasi');
    Route::patch('/user/tambahPembina/{id}', [UserController::class, 'tambahPembina'])->name('user.tambahPembina');

    // PROPOSAL
    Route::patch('/proposal/tindakan/{id}', [ProposalController::class, 'tindakan'])->name('proposal.tindakan');
    Route::patch('/proposal/peringatan/{id}', [ProposalController::class, 'peringatan'])->name('proposal.peringatan');
    Route::get('/proposal/template/{id}', [ProposalController::class, 'template'])->name('proposal.template');
    Route::patch('/proposal/print/', [ProposalController::class, 'print'])->name('proposal.print');
    Route::get('/proposal/download/{id}', [ProposalController::class, 'download'])->name('proposal.download');

    // LPJ
    Route::patch('/lpj/tindakan/{id}', [LpjController::class, 'tindakan'])->name('lpj.tindakan');
    Route::patch('/lpj/peringatan/{id}', [LpjController::class, 'peringatan'])->name('lpj.peringatan');
    Route::get('/lpj/template/{id}', [LpjController::class, 'template'])->name('lpj.template');
    Route::patch('/lpj/print/', [LpjController::class, 'print'])->name('lpj.print');
    Route::get('/lpj/download/{id}', [LpjController::class, 'download'])->name('lpj.download');
    Route::post('/upload/lpj', [LpjController::class, 'upload'])->name('lpj.upload');

    // ORMAWA
    Route::get('/ormawa/lpj/{id}', [OrmawaController::class, 'lpj'])->name('ormawa.lpj');
    Route::patch('/ormawa/lpj/{id}', [OrmawaController::class, 'createLpj'])->name('ormawa.create.lpj');
    Route::get('/ormawa/lpj/download/{id}', [OrmawaController::class, 'downloadLpj'])->name('ormawa.download.lpj');
    Route::get('/ormawa/daftar/{ormawa_id}/{user_id}', [OrmawaController::class, 'daftar'])->name('ormawa.daftar');
    Route::patch('/ormawa/gantiOrmawa/', [OrmawaController::class, 'gantiOrmawa'])->name('ormawa.gantiOrmawa');

    // Lainnya
    Route::delete('/feedback/{id}', [HomeController::class, 'destroyFeedback'])->name('feedback.destroy');
    Route::delete('/komentar/{id}', [HomeController::class, 'destroyKomentar'])->name('komentar.destroy');

    Route::get('/notifikasi', [HomeController::class, 'notifikasi'])->name('notifikasi');

    Route::get('/', [HomeController::class, 'index']);

    Route::resource('ormawa', OrmawaController::class);
    Route::resource('user', UserController::class);
    Route::resource('galeri-ormawa', GaleriOrmawaController::class);
    Route::resource('prestasi-ormawa', PrestasiOrmawaController::class);
    Route::resource('proker', ProkerController::class);
    Route::resource('proposal', ProposalController::class);
    Route::resource('lpj', LpjController::class);

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
