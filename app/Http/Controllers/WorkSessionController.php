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
        $session = WorkSession::where('id', $id)
                              ->where('user_id', Auth::id())
                              ->firstOrFail();

        $session->end_time = now();
        $session->description = $request->input('description');
        $session->total_hours = $session->start_time->diffInHours($session->end_time);
        $session->save();

        return redirect('/');
}
}