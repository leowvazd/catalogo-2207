@extends('admin.layouts.app')

@section('title')
<title>Cadastro de Produto</title>

@section('content')
<div class="container py-4">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @if($product)
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Editar Produto</h1>
            @else
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Cadastrar Novo Produto</h1>
            @endif
            <p class="text-muted small mb-0">Preencha as informações do produto para disponibilizá-lo na plataforma.</p>
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <!-- Alertas Globais -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <strong>Por favor, corrija os erros abaixo antes de salvar.</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulário de Cadastro -->
    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        @if ($product)
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Coluna Principal (Informações do Produto) -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-info-circle me-1"></i> Informações Gerais
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Nome do Produto -->
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-semibold">Nome do Produto <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $product?->name)  }}" 
                                       placeholder="Ex: Camiseta Algodão Premium" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- UM -->
                            <div class="col-md-4">
                                <label for="measure_unit" class="form-label fw-semibold">Unidade de Medida <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('measure_unit') is-invalid @enderror" 
                                       id="measure_unit" 
                                       name="measure_unit" 
                                       value="{{ old('measure_unit', $product?->measure_unit) }}" 
                                       placeholder="Ex: UN" 
                                       required>
                                @error('measure_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descrição -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Descrição</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="5" 
                                          placeholder="Descreva detalhes, especificações e diferenciais do produto...">{{ old('description', $product?->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral (Opções de Visibilidade e Status) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 80px; z-index: 1;">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-sliders me-1"></i> Visibilidade & Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Campo Ativo -->
                        <div class="form-check mb-4 p-3 bg-light rounded border ps-5">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $product?->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Produto Ativo
                            </label>
                            <small class="d-block text-muted mt-1">Exibe este produto no catálogo público da plataforma.</small>
                        </div>

                        <!-- Campo Destaque -->
                        <div class="form-check mb-4 p-3 bg-light rounded border ps-5">
                            <input class="form-check-input" 
                                type="checkbox" 
                                id="is_featured" 
                                name="is_featured" 
                                value="1" 
                                {{ old('is_featured', $product?->is_featured ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_featured">
                                Produto em Destaque
                            </label>
                            <small class="d-block text-muted mt-1">Destaca o item na página principal do e-commerce.</small>
                        </div>

                        <hr>

                        <!-- Botões de Ação -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-floppy me-1"></i> Salvar Produto
                            </button>
                            <button type="reset" class="btn btn-light text-muted">
                                Limpar Formulário
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Cabeçalho das Variantes --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Variantes </h1>
        <a href="" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Nova Variante
        </a>
    </div>

    <pre>
        {{ $product }}
    </pre>

    @if($product)
        {{-- Variantes --}}
        @php
            $products = array();
        @endphp
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Imagens</th>
                                <th scope="col">Sku</th>
                                <th scope="col">Atributos</th>
                                <th scope="col">Preço</th>
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
                                            <a href="{{ route('products.index', $product) }}" class="btn btn-outline-primary" title="Visualizar">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('products.edit', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-outline-secondary" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja mover este produto para a lixeira?');">
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
                                        Nenhuma variante encontrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Rodapé do Card com os Links de Paginação do Bootstrap --}}
            {{--  
            @if($products->hasPages())
                <div class="card-footer d-flex justify-content-center py-3">
                    {{ $products->links() }}
                </div>
            @endif
            --}}
        </div>

    @endif



</div>
@endsection