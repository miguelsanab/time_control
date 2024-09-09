<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkSessionController;
use App\Http\Controllers\PDFController; // Importar el controlador de PDF
use Illuminate\Support\Facades\Auth;

// Rutas para autenticación
Auth::routes(); // Incluye rutas para login, register, etc.

// Ruta principal (mostrará el control de horas si el usuario está autenticado)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('sessions.index'); // Redirige a la vista de control de horas
    } else {
        return view('welcome'); // Muestra la vista de bienvenida si no está autenticado
    }
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas de sesiones de trabajo
    Route::post('/sessions/start', [WorkSessionController::class, 'startSession'])->name('sessions.start');
    Route::post('/sessions/end/{id}', [WorkSessionController::class, 'endSession'])->name('sessions.end');
    Route::get('/sessions', [WorkSessionController::class, 'index'])->name('sessions.index');

    // Ruta para generar el reporte en PDF
    Route::get('/reporte/pdf', [WorkSessionController::class, 'generarPDF'])->name('reporte.pdf');});