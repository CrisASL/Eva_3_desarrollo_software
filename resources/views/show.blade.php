@extends('layouts.app')

@section('title', 'Proyecto')

@section('content')

@if(isset($error))
    <p>{{ $error }}</p>
@else
    <h2>Proyecto: {{ $proyecto->nombre ?? 'Sin nombre' }}</h2>
    <ul>
        <li>ID: {{ $proyecto->id ?? '-' }}</li>
        <li>Fecha de inicio: {{ $proyecto->fecha_de_inicio ?? '-' }}</li>
        <li>Estado: {{ $proyecto->estado ?? '-' }}</li>
        <li>Responsable: {{ $proyecto->responsable ?? '-' }}</li>
        <li>Monto: {{ $proyecto->monto ?? '-' }}</li>
    </ul>
@endif

@endsection
