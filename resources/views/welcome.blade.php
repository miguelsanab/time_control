<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @auth
            <h2 class="text-center mb-4">Mis Sesiones de Trabajo</h2>

            <!-- Botón para descargar el reporte en PDF -->
            <div class="text-right mb-3">
                <a href="{{ route('reporte.pdf') }}" class="btn btn-info" target="_blank">Descargar Reporte en PDF</a>
            </div>

            @if ($sessions->isNotEmpty())
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora de Inicio</th>
                            <th>Hora de Fin</th>
                            <th>Total Horas</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $session)
                        <tr>
                            <td>{{ $session->start_time->format('Y-m-d') }}</td>
                            <td>{{ $session->start_time->format('H:i:s') }}</td>
                            <td>{{ $session->end_time ? $session->end_time->format('H:i:s') : '---' }}</td>
                            <td>{{ $session->total_hours ?? '---' }}</td>
                            <td>{{ $session->description }}</td>
                            <td>
                                @if (!$session->end_time)
                                <form action="{{ route('sessions.end', $session->id) }}" method="POST">
                                    @csrf
                                    <input type="text" name="description" class="form-control mb-2" placeholder="Descripción" required>
                                    
                                    <!-- Checkbox para hora de almuerzo -->
                                    <div class="form-check">
                                        <input type="checkbox" name="lunch_taken" class="form-check-input" id="lunchTaken{{ $session->id }}">
                                        <label class="form-check-label" for="lunchTaken{{ $session->id }}">Tomé una hora de almuerzo</label>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Terminar</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay sesiones de trabajo registradas.</p>
            @endif

            <form action="{{ route('sessions.start') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Iniciar Sesión de Trabajo</button>
            </form>

            <a href="{{ route('logout') }}" class="btn btn-link mt-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        @else
            <div class="text-center">
                <p><a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a> | <a href="{{ route('register') }}" class="btn btn-secondary">Registrar</a></p>
            </div>
        @endauth
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>