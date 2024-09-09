<?php

namespace App\Http\Controllers;

use TCPDF;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSession;

class PDFController extends Controller
{
    // Otros métodos del controlador...

    public function generarPDF()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $sessions = WorkSession::where('user_id', $user->id)->get();

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

        // Escribir el HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Salida del PDF (I para visualizar en el navegador)
        $pdf->Output('reporte_sesiones.pdf','I');
}
}