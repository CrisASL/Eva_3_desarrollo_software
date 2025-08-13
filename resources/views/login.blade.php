@extends('layouts.app')

@section('title', 'Inicio de Sesión')

@section('content')
    <h1>Iniciar Sesión</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('usuario.login') }}">
        @csrf

        <div>
            <label for="correo">Correo:</label><br/>
            <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required>
        </div>

        <div>
            <label for="contraseña">Contraseña:</label><br/>
            <input type="password" id="contraseña" name="contraseña" required>
        </div>

        <button type="submit">Iniciar Sesión</button>
    </form>
@endsection