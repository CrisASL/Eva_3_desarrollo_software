@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('content')
    <h1>Editar Proyecto</h1>

    <form action="{{ route('proyectos.update', $proyecto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre">Nombre del Proyecto</label>
            <input type="text" name="nombre" placeholder="Nombre del proyecto" value="{{ old('nombre', $proyecto->nombre) }}" required>
            @error('nombre')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $proyecto->fecha_inicio) }}" required>
            @error('fecha_inicio')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="estado">Estado</label>
            <input type="text" name="estado" placeholder="Estado" value="{{ old('estado', $proyecto->estado) }}" required>
            @error('estado')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="responsable">Responsable</label>
            <input type="text" name="responsable" placeholder="Responsable" value="{{ old('responsable', $proyecto->responsable) }}" required>
            @error('responsable')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="monto">Monto</label>
            <input type="number" name="monto" placeholder="Monto" value="{{ old('monto', $proyecto->monto) }}" required>
            @error('monto')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <button type="submit">Actualizar Proyecto</button>
    </form>
@endsection