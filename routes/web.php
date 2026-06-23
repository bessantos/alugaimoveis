<?php

use App\Http\Controllers\CasaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ProfileController;
use App\Models\Casa;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [CasaController::class, 'publicIndex'])->name('home');
Route::get('/casa/{id}', [CasaController::class, 'show'])->name('casas.show');

Route::get('/dashboard', function () {
    $totalCasas = Casa::where('user_id', Auth::id())->count();
    $totalReservas = Reserva::where('user_id', Auth::id())->count();
    $reservasPendentes = Reserva::where('user_id', Auth::id())
        ->where('check_in', '>=', today())->count();

    // Agrupa por mês do check_in do ano atual
    $reservas = Reserva::where('user_id', Auth::id())
        ->whereYear('check_in', now()->year)
        ->get();

    $agrupado = [];
    foreach ($reservas as $reserva) {
        $mes = date('m/Y', strtotime($reserva->check_in));
        if (!isset($agrupado[$mes])) {
            $agrupado[$mes] = 0;
        }
        $agrupado[$mes]++;
    }

    ksort($agrupado);

    $meses = array_keys($agrupado);
    $quantidades = array_values($agrupado);

    return view('dashboard', compact(
        'totalCasas',
        'totalReservas',
        'reservasPendentes',
        'meses',
        'quantidades'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/casas', [CasaController::class, 'index'])->name('casas.index');
    Route::get('/casas/nova', [CasaController::class, 'create'])->name('casas.create');
    Route::post('/casas/nova', [CasaController::class, 'store'])->name('casas.store');
    Route::get('/casas/editar/{id}', [CasaController::class, 'edit'])->name('casas.edit');
    Route::post('/casas/editar', [CasaController::class, 'update'])->name('casas.update');
    Route::get('/casas/excluir/{id}', [CasaController::class, 'destroy'])->name('casas.destroy');

    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/nova/{casa_id}', [ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservas/nova', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/reservas/cancelar/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');

    Route::get('/admin/reservas', [ReservaController::class, 'adminIndex'])->name('admin.reservas');
});

require __DIR__ . '/auth.php';
