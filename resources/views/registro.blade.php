@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')
    <h1>Registro de Usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('usuario.registrar') }}">
        @csrf

        <div>
            <label for="nombre">Nombre:</label><br/>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div>
            <label for="correo">Correo:</label><br/>
            <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required>
        </div>

        <div>
            <label for="contraseña">Contraseña:</label><br/>
            <input type="password" id="contraseña" name="contraseña" required>
        </div>

        <button type="submit">Registrar</button>
    </form>
@endsection