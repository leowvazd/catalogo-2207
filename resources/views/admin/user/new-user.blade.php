@extends('admin.user.layouts.app')

@section('title', 'Cadastro de Usuários')

@section('content')
    <h1>Novo Usuário</h1>

    {{-- @include('admin.includes.errors') --}}
    {{-- inclusão de componentes blade <x-[nomecomponente]> --}}
    <x-alert/>

    <div>
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf()
        <input type="text" name="name" placeholder="Nome" value="{{ old('name') }}">
        <input type="email" name ="email" placeholder="E-mail" value="{{ old('email') }}">
        <input type="password" name ="password" placeholder="Senha" >
        <button type="submit">Enviar</button>

    </form>
@endsection