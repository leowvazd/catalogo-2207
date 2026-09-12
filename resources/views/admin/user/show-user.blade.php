@extends('admin.user.layouts.app')

@section('title', 'Detalhes dos Usuários')

@section('content')
    <h1>Detalhes do usuário</h1>

    {{-- @include('admin.includes.errors') --}}
    {{-- inclusão de componentes blade <x-[nomecomponente]> --}}
    <x-alert />

    <ul>
        <li>Nome: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
    </ul>

    @can('is-admin') {{-- Aparece somente pro usuário que é admin --}}
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-danger" title="Excluir">
                <i class="bi bi-trash">Excluir</i>
            </button> 
        </form>
    @endcan
    
@endsection