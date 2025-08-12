@extends('layouts.app')

@section('title', 'Crear Proyecto')

@section('content')
    <h1>Crear Proyecto</h1>

    <form action="/api/proyectos" method="POST">
        @csrf

        <div>
            <label for="nombre">Nombre del Proyecto</label>
            <input type="text" name="nombre" placeholder="Nombre del proyecto" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
            @error('fecha_inicio')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="estado">Estado</label>
            <input type="text" name="estado" placeholder="Estado" value="{{ old('estado') }}" required>
            @error('estado')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="responsable">Responsable</label>
            <input type="text" name="responsable" placeholder="Responsable" value="{{ old('responsable') }}" required>
            @error('responsable')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div>
            <label for="monto">Monto</label>
            <input type="number" name="monto" placeholder="Monto" value="{{ old('monto') }}" required>
            @error('monto')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <button type="submit">Crear Proyecto</button>
    </form>
@endsection