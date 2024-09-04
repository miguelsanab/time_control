@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mis Sesiones de Trabajo</h2>
    <table class="table">
        <thead>
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
                        <input type="text" name="description" placeholder="Descripción">
                        <button type="submit" class="btn btn-primary">Terminar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{ route('sessions.start') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Iniciar Sesión de Trabajo</button>
    </form>
</div>
@endsection