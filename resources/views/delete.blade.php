@extends('layouts.app')

@section('title', 'Eliminar Proyecto')

@section('content')
    <h1>Eliminar Proyecto</h1>

    <p>¿Estás seguro de que deseas eliminar el proyecto "{{ $proyecto->nombre }}"?</p>

    <form action="{{ route('proyectos.delete', $proyecto->id) }}" method="POST">
        @csrf
        @method('DELETE') <!-- Simula el método DELETE -->
        <button type="submit">Eliminar</button>
        <a href="{{ route('proyectos.showall') }}">Cancelar</a>
    </form>
@endsection