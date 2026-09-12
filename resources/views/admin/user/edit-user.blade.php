@extends('admin.user.layouts.app')

@section('title', 'Editar Usuários')

@section('content')
    <h1>Editar usuario {{ $user->name }}</h1>

    {{-- @include('admin.includes.errors') --}}
    {{-- inclusão de componentes blade <x-[nomecomponente]> --}}
    <x-alert />

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf()
        @method('put')
        <input type="text" name="name" placeholder="Nome" value="{{ $user->name }}">
        <input type="email" name ="email" placeholder="E-mail" value="{{ $user->email }}">
        <input type="password" name ="password" placeholder="Senha" >
        <button type="submit">Enviar</button>

    </form>
    
@endsection