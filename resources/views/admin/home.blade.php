@extends('layouts.admin')

{{-- Esto rellenará el <title> de tu layout --}}
@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="mb-4">Bienvenido al Panel de Administración</h1>
    <p>Desde aquí podrás gestionar recursos, usuarios y reportes.</p>

    {{-- Si luego quieres meter estadísticas, gráficas o listados lo añades aquí --}}
@endsection
