@extends('admin.layouts.app')

@section('title')
<title>Produtos</title>

@section('content')
<div class="container py-4">

    {{-- Cabeçalho da Página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produtos</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Novo Produto
        </a>
    </div>

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
            <form action="{{ route('products.index') }}" method="GET" class="row g-2 align-items-center">
                {{-- Combobox: Critério de busca --}}
                <div class="col-md-3">
                    <select name="search_type" class="form-select">
                        <option value="name" {{ request('search_type') == 'name' ? 'selected' : '' }}>Nome</option>
                        <option value="sku" {{ request('search_type') == 'sku' ? 'selected' : '' }}>SKU</option>
                    </select>
                </div>

                {{-- Input: Termo da Pesquisa --}}
                <div class="col-md-6 flex-grow-1">
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
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela de Produtos --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Un. de Medida</th>
                            <th scope="col">Estoque</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center pe-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->is_featured)
                                        <span class="badge bg-warning text-dark ms-1" title="Produto Destaque">
                                            <i class="bi bi-star-fill"></i> Destaque
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <p>{{ $product->measure_unit}}</p>
                                </td>
                                <td>
                                    @if($product->stock_quantity > 5 )
                                        <span class="badge bg-info text-dark">{{ $product->stock_quantity }} un</span>
                                    @elseif($product->stock_quantity > 0)
                                        <span class="badge bg-warning text-dark">{{ $product->stock_quantity }} un (Baixo)</span>
                                    @else
                                        <span class="badge bg-danger">Esgotado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-secondary">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-center pe-3">
                                    <div>
                                        {{--  
                                        <a href="{{ route('products.index', $product) }}" class="btn btn-outline-primary" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        --}}
                                        <form action="{{ route('products.edit', $product->id) }}" method="GET" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja mover este produto para a lixeira?');">
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
                                    Nenhum produto encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Rodapé do Card com os Links de Paginação do Bootstrap --}}
        @if($products->hasPages())
            <div class="card-footer d-flex justify-content-center py-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

