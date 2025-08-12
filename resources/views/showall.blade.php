@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
    <h2>Lista de Proyectos</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($proyectos) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha de Inicio</th>
                    <th>Estado</th>
                    <th>Responsable</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyectos as $proyecto)
                    <tr>
                        <td>{{ $proyecto->id }}</td>
                        <td>{{ $proyecto->nombre }}</td>
                        <td>{{ $proyecto->fecha_inicio }}</td>
                        <td>{{ $proyecto->estado }}</td>
                        <td>{{ $proyecto->responsable }}</td>
                        <td>{{ $proyecto->monto }}</td>
                        <td>
                            <a href="{{ route('proyectos.show', $proyecto->id) }}">Ver</a>
                            <a href="{{ route('proyectos.edit', $proyecto->id) }}">Editar</a>
                            <form action="{{ route('proyectos.destroy', $proyecto->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay proyectos disponibles.</p>
    @endif
@endsection