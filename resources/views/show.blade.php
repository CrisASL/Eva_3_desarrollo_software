@extends('layouts.app')

@section('title', 'Proyecto Detalle')

@section('content')
    <h1>Detalles del Proyecto</h1>

    @if(isset($proyecto))
        <div>
            <h2>{{ $proyecto->nombre }}</h2>
            <p><strong>Fecha de Inicio:</strong> {{ $proyecto->fecha_inicio }}</p>
            <p><strong>Estado:</strong> {{ $proyecto->estado }}</p>
            <p><strong>Responsable:</strong> {{ $proyecto->responsable }}</p>
            <p><strong>Monto:</strong> ${{ number_format($proyecto->monto, 2) }}</p>
        </div>

        <div>
            <a href="{{ route('proyectos.edit', $proyecto->id) }}">Editar Proyecto</a>
            <form action="{{ route('proyectos.delete', $proyecto->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar Proyecto</button>
            </form>
        </div>
    @else
        <p>{{ $error }}</p>
    @endif
@endsection