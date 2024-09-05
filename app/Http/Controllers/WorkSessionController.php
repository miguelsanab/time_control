<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSession;

class WorkSessionController extends Controller
{
    public function index()
    {
        // Obtén todas las sesiones del usuario autenticado
        $sessions = Auth::user()->workSessions()->get();
        return view('welcome', compact('sessions'));
    }

    public function startSession(Request $request)
    {
        WorkSession::create([
            'user_id' => Auth::id(),
            'start_time' => now(),
        ]);

        return redirect('/');
    }

    public function endSession(Request $request, $id)
    {
        // Busca la sesión por ID y verifica que pertenezca al usuario autenticado
        $session = WorkSession::where('id', $id)
                              ->where('user_id', Auth::id())
                              ->firstOrFail();

        // Actualiza los campos de la sesión
        $session->end_time = now();
        $session->description = $request->input('description');
        $session->lunch_taken = $request->has('lunch_taken'); // Determina si se tomó la hora de almuerzo

        // Calcula las horas trabajadas considerando la hora de almuerzo
        $totalHours = $session->start_time->diffInHours($session->end_time);
        if ($session->lunch_taken) {
            $totalHours -= 1; // Resta 1 hora si se tomó almuerzo
        }
        $session->total_hours = $totalHours;
        $session->save();

        return redirect('/');
}
}