<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSession;
use TCPDF;


class WorkSessionController extends Controller
{
    public function index()
    {
        // Obtén todas las sesiones del usuario autenticado
        $sessions = Auth::user()->workSessions()->get();
        return view('welcome', compact('sessions'));
    }
    public function generarPDF()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $sessions = WorkSession::where('user_id', $user->id)->get();

        // Calcular la sumatoria total de horas trabajadas
        $totalHours = 0;
        foreach ($sessions as $session) {
            if ($session->total_hours) {
                $totalHours += $session->total_hours;
            }
        }

        // Crear una instancia de TCPDF
        $pdf = new TCPDF();

        // Establecer la información del documento
        $pdf->SetCreator('Time Tracker');
        $pdf->SetAuthor($user->name); // Nombre del autor (usuario)
        $pdf->SetTitle('Reporte de Sesiones de Trabajo');
        $pdf->SetSubject('Reporte de horas trabajadas');
        $pdf->SetKeywords('PDF, reporte, trabajo, horas');

        // Configurar el encabezado
        $pdf->SetHeaderData('', 0, 'Reporte de Sesiones de Trabajo', "Usuario: {$user->name}\nCorreo: {$user->email}");

        // Establecer fuentes
        $pdf->setHeaderFont(['helvetica', '', 10]);
        $pdf->setFooterFont(['helvetica', '', 8]);

        // Márgenes
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);

        // Añadir página
        $pdf->AddPage();

        // Configurar la fuente para el contenido
        $pdf->SetFont('helvetica', '', 12);

        // Crear el contenido de la tabla
        $html = '<h2>Listado de Sesiones</h2>
                 <table border="1" cellpadding="4">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora de Inicio</th>
                            <th>Hora de Fin</th>
                            <th>Total Horas</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($sessions as $session) {
            $html .= '<tr>
                        <td>' . $session->start_time->format('Y-m-d') . '</td>
                        <td>' . $session->start_time->format('H:i:s') . '</td>
                        <td>' . ($session->end_time ? $session->end_time->format('H:i:s') : '---') . '</td>
                        <td>' . ($session->total_hours ?? '---') . '</td>
                        <td>' . $session->description . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        // Añadir la sumatoria total de horas al final del PDF
        $html .= '<h3>Total de Horas Trabajadas: ' . $totalHours . ' horas</h3>';

        // Escribir el HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Salida del PDF (I para visualizar en el navegador)
        $pdf->Output('reporte_sesiones.pdf','I');
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