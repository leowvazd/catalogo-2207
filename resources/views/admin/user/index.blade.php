@extends('admin.user.layouts.app')

@section('title', 'Usuário')

@section('content')
<div class="container">
    <!-- Card Principal -->
    <div class="card shadow-sm border-0">
        
        <!-- Cabeçalho do Card -->
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0 text-gray-800">
                <i class="bi bi-people-fill text-primary me-2"></i>Usuários
            </h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i>Novo Usuário
            </a>
        </div>

        <x-alert/>

        <!-- Corpo do Card / Tabela -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col" class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="d-none d-md-block">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $user->name }}</td>
                                    <td class="text-secondary">{{ $user->email }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-secondary" title="Editar">
                                                <i class="bi bi-pencil">Editar</i>
                                            </a>
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-primary" title="Detalhes">
                                                <i class="bi bi-pencil">Detalhes</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                        Nenhum usuário encontrado no banco.
                                    </td>
                                </tr>
                            @endforelse
                        </div>

                        <div class="d-block d-md-none">
                            @forelse ($users as $user)
                                <div class="card mb-3 shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title h6 fw-bold mb-1">{{ $user->name }}</h5>
                                        <p class="card-text text-muted small mb-2">{{ $user->email }}</p>
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="#" class="btn btn-sm btn-outline-secondary">Editar</a>
                                            <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3">Nenhum usuário encontrado.</p>
                            @endforelse
                        </div>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Rodapé do Card / Paginação -->
        @if (method_exists($users, 'hasPages') && $users->hasPages())
            <div class="card-footer bg-white py-3 d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        @endif

    </div>
</div>
@endsection