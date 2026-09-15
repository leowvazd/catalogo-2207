@extends('admin.layouts.app')

@section('title')
<title>Produtos</title>

@section('content')
<div class="container py-4">
    
    {{-- Cabeçalho da Página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Atributos</h1>

        {{-- Botão que aciona o Modal --}}
        <button type="button" class="btn btn-success btn fw-semibold" data-bs-toggle="modal" data-bs-target="#newAttributeModal" title="Novo">
            <i class="bi bi-plus-lg me-1"></i> Novo Atributo
        </button>
    </div>

    {{-- Estrutura Completa do Modal Para Cadastro de Atributo --}}
    <div class="modal fade" id="newAttributeModal" aria-labelledby="newAttributeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="newAttributeModalLabel">Novo Atributo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                
                <form action="{{ route('attributes.store') }}" method="POST">
                    @csrf
                    
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label for="optionName" class="form-label">Nome do Atributo <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="attributeName" 
                                name="name"
                                value="{{ old('name') }}" 
                                placeholder="Digite o nome do novo atributo..." 
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Fim do Modal --}}

    {{-- Alerta de Mensagens de Sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card com Formulário de Pesquisa --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold fs-4">Pesquisar</h5>
            <form action="{{ route('attributes.index') }}" method="GET" class="row g-2 align-items-center">

                {{-- Input: Termo da Pesquisa --}}
                <div class="col-md-9 flex-grow-1">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Digite o termo para buscar..." 
                        value="{{ request('search') }}"
                    >
                </div>

                {{-- Botões de Ação --}}
                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Pesquisar
                    </button>
                    
                    @if(request('search'))
                        <a href="{{ route('attributes.index') }}" class="btn btn-outline-secondary">
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela de Atributos --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center pe-3">Nome</th>
                            <th scope="col">Opções</th>
                            <th scope="col" class="text-center pe-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attributes as $attribute)
                            <tr>
                                <td class="text-center pe-3">
                                    <strong>{{ $attribute->name }}</strong>
                                </td>
                                <td>
                                    {{-- Iterando sobre as opções do atributo para criar os badges --}}
                                    @forelse ($attribute->options as $item)
                                        <span class="badge bg-secondary me-1">{{ $item->option }}</span>
                                    @empty
                                        <span class="text-muted small">Nenhuma opção cadastrada</span>
                                    @endforelse
                                </td>
                                <td class="text-center pe-3">
                                    <div>
                                        <form action="{{ route('attributes.edit', $attribute) }}" method="GET" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja mover este atributo para a lixeira?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Nenhum atributo encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Rodapé do Card com os Links de Paginação do Bootstrap --}}
        @if($attributes->hasPages())
            <div class="card-footer d-flex justify-content-center py-3">
                {{ $attributes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection