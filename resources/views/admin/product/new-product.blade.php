@extends('admin.layouts.app')

@section('title')
    <title>Cadastro de Produto</title>
@endsection

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

            <p class="text-muted small mb-0">
                Preencha as informações do produto para disponibilizá-lo na plataforma.
            </p>
        </div>

        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Voltar para Lista
            </a>
        </div>
    </div>


    <!-- Alertas Globais -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">

            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>

                <strong>
                    Por favor, corrija os erros abaixo antes de salvar.
                </strong>
            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>
    @endif


    <!-- Formulário de Produto -->
    @if ($product)

        <form action="{{ route('products.update', $product->id) }}"
              method="POST">

            @csrf
            @method('PUT')

    @else

        <form action="{{ route('products.store') }}"
              method="POST">

            @csrf

    @endif

        <div class="row g-4">

            <!-- Coluna Principal -->
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-info-circle me-1"></i>
                            Informações Gerais
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <!-- Nome -->
                            <div class="col-md-8">

                                <label for="name"
                                       class="form-label fw-semibold">

                                    Nome do Produto
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $product?->name) }}"
                                       placeholder="Ex: Camiseta Algodão Premium"
                                       required>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <!-- Unidade de Medida -->
                            <div class="col-md-4">

                                <label for="measure_unit"
                                       class="form-label fw-semibold">

                                    Unidade de Medida
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text"
                                       class="form-control @error('measure_unit') is-invalid @enderror"
                                       id="measure_unit"
                                       name="measure_unit"
                                       value="{{ old('measure_unit', $product?->measure_unit) }}"
                                       placeholder="Ex: UN"
                                       required>

                                @error('measure_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <!-- Descrição -->
                            <div class="col-12">

                                <label for="description"
                                       class="form-label fw-semibold">

                                    Descrição

                                </label>

                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="5"
                                          placeholder="Descreva detalhes, especificações e diferenciais do produto...">{{ old('description', $product?->description) }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Coluna Lateral -->
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm sticky-top"
                     style="top: 80px; z-index: 1;">

                    <div class="card-header bg-white py-3">

                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-sliders me-1"></i>
                            Visibilidade & Status
                        </h5>

                    </div>


                    <div class="card-body">

                        <!-- Produto Ativo -->
                        <div class="form-check mb-4 p-3 bg-light rounded border ps-5">

                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $product?->is_active ?? true) ? 'checked' : '' }}>

                            <label class="form-check-label fw-semibold"
                                   for="is_active">

                                Produto Ativo

                            </label>

                            <small class="d-block text-muted mt-1">
                                Exibe este produto no catálogo público da plataforma.
                            </small>

                        </div>


                        <!-- Produto em Destaque -->
                        <div class="form-check mb-4 p-3 bg-light rounded border ps-5">

                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_featured"
                                   name="is_featured"
                                   value="1"
                                   {{ old('is_featured', $product?->is_featured ?? true) ? 'checked' : '' }}>

                            <label class="form-check-label fw-semibold"
                                   for="is_featured">

                                Produto em Destaque

                            </label>

                            <small class="d-block text-muted mt-1">
                                Destaca o item na página principal do e-commerce.
                            </small>

                        </div>


                        <hr>


                        <!-- Botões -->
                        <div class="d-grid gap-2">

                            <button type="submit"
                                    class="btn btn-primary btn-lg">

                                <i class="bi bi-floppy me-1"></i>
                                Salvar Produto

                            </button>

                            <button type="reset"
                                    class="btn btn-light text-muted">

                                Limpar Formulário

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>


    @if($product)

        <!-- Cabeçalho das Variantes -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <h1 class="h3 mb-0 text-gray-800">
                Variantes
            </h1>

            <button type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#createVariantModal">

                <i class="bi bi-plus-lg me-1"></i>
                Nova Variante

            </button>

        </div>


        <!-- Tabela de Variantes -->
        <div class="card shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th scope="col">
                                    Imagens
                                </th>

                                <th scope="col">
                                    SKU
                                </th>

                                <th scope="col">
                                    Atributos
                                </th>

                                <th scope="col">
                                    Preço
                                </th>

                                <th scope="col">
                                    Estoque
                                </th>

                                <th scope="col">
                                    Status
                                </th>

                                <th scope="col"
                                    class="text-center pe-3">

                                    Ações

                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($variants as $variant)

                                <tr>

                                    <!-- Imagens -->
                                    <td>

                                        <button type="button"
                                                class="btn btn-outline-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewImagesModal-{{ $variant->id }}"
                                                title="Imagens">

                                            <i class="bi bi-camera-fill"></i>

                                        </button>

                                    </td>


                                    <!-- SKU -->
                                    <td>

                                        <strong>
                                            {{ $variant->sku }}
                                        </strong>

                                    </td>


                                    <!-- Atributos -->
                                    <td>
                                        
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#attributesVariantModal-{{ $variant->id }}">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Atributo
                                        </button>

                                        @forelse($variant->variantAttributes as $vAttribute)

                                            <span class="badge bg-light text-dark border mb-1">

                                                <strong>
                                                    {{ optional($vAttribute->attribute)->name }}:
                                                </strong>

                                                {{ optional($vAttribute->attributeOption)->option }}

                                            </span>

                                            <br>

                                        @empty

                                            <span class="text-muted small">
                                                Sem atributos
                                            </span>

                                        @endforelse

                                    </td>


                                    <!-- Preço -->
                                    <td>

                                        @if($variant->price !== null)

                                            R$
                                            {{ number_format($variant->price / 100, 2, ',', '.') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    <!-- Estoque -->
                                    <td>

                                        @if($variant->stock > 0)

                                            <span class="badge bg-info text-dark">
                                                {{ $variant->stock }} un
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Esgotado
                                            </span>

                                        @endif

                                    </td>


                                    <!-- Status -->
                                    <td>

                                        @if($variant->is_active)

                                            <span class="badge bg-success">
                                                Ativo
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Inativo
                                            </span>

                                        @endif

                                    </td>


                                    <!-- Ações -->
                                    <td class="text-center pe-3">

                                        <div>

                                            <!-- Editar -->
                                            <button type="button"
                                                    class="btn btn-outline-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editVariantModal-{{ $variant->id }}"
                                                    title="Editar">

                                                <i class="bi bi-pencil"></i>

                                            </button>


                                            <!-- Excluir -->
                                            <form action="{{ route('variants.destroy', [
                                                        'product' => $product->id,
                                                        'variant' => $variant->id
                                                    ]) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Tem certeza que deseja mover esta variante para a lixeira?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-outline-danger"
                                                        title="Excluir">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                                <!-- ================================================= -->
                                <!-- Modal de Atributos da Variante -->
                                <!-- ================================================= -->
                                <div class="modal fade"
                                    id="attributesVariantModal-{{ $variant->id }}"
                                    tabindex="-1"
                                    aria-labelledby="attributesVariantModalLabel-{{ $variant->id }}"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <div>
                                                    <h5 class="modal-title"
                                                        id="attributesVariantModalLabel-{{ $variant->id }}">
                                                        Atributos da Variante
                                                    </h5>
                                                    <small class="text-muted">
                                                        SKU: {{ $variant->sku }}
                                                    </small>
                                                </div>
                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal">
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                {{-- ========================================================= --}}
                                                {{-- CARD DE INCLUSÃO --}}
                                                {{-- ========================================================= --}}

                                                <div class="card border-primary mb-3">

                                                    <div class="card-header bg-primary text-white">
                                                        <i class="bi bi-plus-circle me-1"></i>
                                                    </div>

                                                    <div class="card-body">

                                                        <form method="POST"
                                                            action="{{ route('variants.attributes.store', [
                                                                'product' => $product->id,
                                                                'variant' => $variant->id
                                                            ]) }}">

                                                            @csrf

                                                            <div class="row g-3 align-items-end">

                                                                {{-- Atributo --}}
                                                                <div class="col-md-5">

                                                                    <label class="form-label">
                                                                        Atributo
                                                                    </label>

                                                                    <select name="attribute_id"
                                                                            class="form-select variant-attribute-select"
                                                                            data-variant-id="{{ $variant->id }}"
                                                                            required>

                                                                        <option value="">
                                                                            Selecione um atributo...
                                                                        </option>

                                                                        @foreach ($attributes as $attribute)

                                                                            <option value="{{ $attribute->id }}">
                                                                                {{ $attribute->name }}
                                                                            </option>

                                                                        @endforeach

                                                                    </select>

                                                                </div>


                                                                {{-- Opção --}}
                                                                <div class="col-md-5">

                                                                    <label class="form-label">
                                                                        Opção
                                                                    </label>

                                                                    <select name="attribute_option_id"
                                                                            class="form-select variant-option-select"
                                                                            required
                                                                            disabled>

                                                                        <option value="">
                                                                            Selecione primeiro o atributo...
                                                                        </option>

                                                                    </select>

                                                                </div>


                                                                {{-- Botão incluir --}}
                                                                <div class="col-md-2">

                                                                    <button type="submit"
                                                                            class="btn btn-success w-100"
                                                                            title="Vincular atributo">

                                                                        <i class="bi bi-plus-lg"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>


                                                {{-- ========================================================= --}}
                                                {{-- TÍTULO DA LISTA --}}
                                                {{-- ========================================================= --}}

                                                <div class="d-flex justify-content-between align-items-center mb-2">

                                                    <h6 class="mb-0">
                                                        Atributos vinculados
                                                    </h6>

                                                    <span class="badge bg-secondary">
                                                        {{ $variant->variantAttributes->count() }}
                                                    </span>

                                                </div>


                                                {{-- ========================================================= --}}
                                                {{-- LISTA ROLÁVEL --}}
                                                {{-- ========================================================= --}}

                                                <div class="overflow-auto pe-1"
                                                    style="max-height: 350px;">

                                                    @forelse ($variant->variantAttributes as $variantAttribute)

                                                        <div class="card mb-2">

                                                            <div class="card-body py-2">

                                                                <div class="row g-2 align-items-end">

                                                                    {{-- Atributo --}}
                                                                    <div class="col-md-5">

                                                                        <label class="form-label mb-1">
                                                                            Atributo
                                                                        </label>

                                                                        <select class="form-select"
                                                                                disabled>

                                                                            <option selected>
                                                                                {{ $variantAttribute->attribute->name }}
                                                                            </option>

                                                                        </select>
                                                                    </div>
                                                                    
                                                                    {{-- Opção --}}
                                                                    <div class="col-md-5">
                                                                        <label class="form-label mb-1">
                                                                            Opção
                                                                        </label>

                                                                        <select class="form-select"
                                                                                disabled>

                                                                            <option selected>
                                                                                {{ $variantAttribute->attributeOption->option }}
                                                                            </option>

                                                                        </select>

                                                                    </div>

                                                                    {{-- Remover --}}
                                                                    <div class="col-md-2">
                                                                        <form method="POST"
                                                                            action="{{ route('variants.attributes.destroy', [
                                                                                'product' => $product->id,
                                                                                'variant' => $variant->id,
                                                                                'variantAttribute' => $variantAttribute->id
                                                                            ]) }}"
                                                                            onsubmit="return confirm('Deseja remover este atributo da variante?');">

                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                    class="btn btn-outline-danger w-100"
                                                                                    title="Remover atributo">

                                                                                <i class="bi bi-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="text-center text-muted py-4">

                                                            <i class="bi bi-tags fs-3 d-block mb-2"></i>

                                                            <p class="mb-0">
                                                                Nenhum atributo vinculado a esta variante.
                                                            </p>

                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ================================================= -->
                                <!-- Modal de Imagens da Variante -->
                                <!-- ================================================= -->

                                <div class="modal fade"
                                     id="viewImagesModal-{{ $variant->id }}"
                                     tabindex="-1"
                                     aria-labelledby="viewImagesModalLabel-{{ $variant->id }}"
                                     aria-hidden="true">

                                    <div class="modal-dialog modal-lg modal-dialog-centered">

                                        <div class="modal-content">


                                            <!-- Modal Header -->
                                            <div class="modal-header">

                                                <div>

                                                    <h5 class="modal-title"
                                                        id="viewImagesModalLabel-{{ $variant->id }}">

                                                        Imagens da Variante

                                                    </h5>

                                                    <small class="text-muted">

                                                        SKU:
                                                        {{ $variant->sku }}

                                                    </small>

                                                </div>


                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                </button>

                                            </div>


                                            <!-- Modal Body -->
                                            <div class="modal-body">


                                                <!-- Carousel -->
                                                @if($variant->images->isNotEmpty())

                                                    <div id="variantCarousel-{{ $variant->id }}"
                                                         class="carousel slide">

                                                        <div class="carousel-inner">

                                                            @foreach($variant->images as $index => $image)

                                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                                                                    <img src="{{ asset('storage/products/variants/' . $image->filename) }}"
                                                                         class="d-block mx-auto img-fluid rounded"
                                                                         style="max-height: 400px;"
                                                                         alt="Imagem da variante {{ $variant->sku }}">


                                                                    <!-- Remover imagem -->
                                                                    <div class="text-center mt-3">

                                                                        <form method="POST"
                                                                              action="{{ route('variants.images.destroy', [
                                                                                  'product' => $product->id,
                                                                                  'variant' => $variant->id,
                                                                                  'image' => $image->id
                                                                              ]) }}"
                                                                              onsubmit="return confirm('Deseja realmente remover esta imagem?');">

                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button type="submit"
                                                                                    class="btn btn-danger">

                                                                                <i class="bi bi-trash me-1"></i>

                                                                                Remover imagem

                                                                            </button>

                                                                        </form>

                                                                    </div>

                                                                </div>

                                                            @endforeach

                                                        </div>
                                                        <!-- Controles -->
                                                        @if($variant->images->count() > 1)
                                                            <button class="carousel-control-prev"
                                                                    type="button"
                                                                    data-bs-target="#variantCarousel-{{ $variant->id }}"
                                                                    data-bs-slide="prev">

                                                                <span class="carousel-control-prev-icon bg-dark rounded"
                                                                      aria-hidden="true">
                                                                </span>

                                                                <span class="visually-hidden">
                                                                    Anterior
                                                                </span>

                                                            </button>

                                                            <button class="carousel-control-next"
                                                                    type="button"
                                                                    data-bs-target="#variantCarousel-{{ $variant->id }}"
                                                                    data-bs-slide="next">

                                                                <span class="carousel-control-next-icon bg-dark rounded"
                                                                      aria-hidden="true">
                                                                </span>

                                                                <span class="visually-hidden">
                                                                    Próxima
                                                                </span>

                                                            </button>

                                                        @endif

                                                    </div>

                                                @else

                                                    <!-- Sem imagens -->
                                                    <div class="text-center py-5">

                                                        <i class="bi bi-images fs-1 text-muted"></i>

                                                        <p class="text-muted mt-2 mb-0">

                                                            Esta variante ainda não possui imagens.

                                                        </p>

                                                    </div>

                                                @endif


                                                <!-- ================================================= -->
                                                <!-- Adicionar Imagem -->
                                                <!-- ================================================= -->

                                                <hr class="my-4">

                                                <div>

                                                    <h6 class="fw-bold mb-3">

                                                        <i class="bi bi-upload me-1"></i>

                                                        Adicionar imagem

                                                    </h6>


                                                    <form method="POST"
                                                          action="{{ route('variants.images.store', [
                                                              'product' => $product->id,
                                                              'variant' => $variant->id
                                                          ]) }}"
                                                          enctype="multipart/form-data">

                                                        @csrf


                                                        <div class="input-group">

                                                            <input type="file"
                                                                   name="image"
                                                                   class="form-control"
                                                                   accept="image/jpeg,image/png,image/webp"
                                                                   required>


                                                            <button type="submit"
                                                                    class="btn btn-primary">

                                                                <i class="bi bi-upload me-1"></i>

                                                                Adicionar imagem

                                                            </button>

                                                        </div>


                                                        <div class="form-text">

                                                            JPG, JPEG, PNG ou WEBP.
                                                            Tamanho máximo: 300 KB.

                                                        </div>

                                                    </form>

                                                </div>

                                            </div>


                                            <!-- Modal Footer -->
                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Fechar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ================================================= -->
                                <!-- Modal Editar Variante -->
                                <!-- ================================================= -->
                                <div class="modal fade"
                                     id="editVariantModal-{{ $variant->id }}"
                                     tabindex="-1"
                                     aria-labelledby="editVariantModalLabel-{{ $variant->id }}"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('variants.update', ['product' => $product->id,'variant' => $variant->id]) }}">
                                                @csrf
                                                @method('PUT')

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editVariantModalLabel-{{ $variant->id }}">
                                                        Editar Variante
                                                    </h5>

                                                    <button type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    </button>

                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    <!-- SKU -->
                                                    <div class="mb-3 text-start">
                                                        <label for="edit_variant_sku_{{ $variant->id }}" class="form-label">
                                                            SKU
                                                            <span class="text-danger">*</span>
                                                        </label>

                                                        <input type="text"
                                                               class="form-control"
                                                               id="edit_variant_sku_{{ $variant->id }}"
                                                               name="sku"
                                                               value="{{ $variant->sku }}"
                                                               required>

                                                    </div>


                                                    <!-- Preço e Estoque -->
                                                    <div class="row mb-3 text-start">
                                                        <!-- Preço -->
                                                        <div class="col-md-6">
                                                            <label for="edit_variant_price_{{ $variant->id }}" class="form-label">
                                                                Preço
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number"
                                                                   step="0.01"
                                                                   min="0"
                                                                   class="form-control"
                                                                   id="edit_variant_price_{{ $variant->id }}"
                                                                   name="price"
                                                                   value="{{ number_format($variant->price / 100, 2, '.', '') }}"
                                                                   required>

                                                        </div>


                                                        <!-- Estoque -->
                                                        <div class="col-md-6">
                                                            <label for="edit_variant_stock_{{ $variant->id }}"class="form-label">
                                                                Estoque
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number"
                                                                   min="0"
                                                                   class="form-control"
                                                                   id="edit_variant_stock_{{ $variant->id }}"
                                                                   name="stock"
                                                                   value="{{ $variant->stock }}"
                                                                   required>

                                                        </div>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="form-check form-switch mt-3 text-start">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               id="edit_variant_active_{{ $variant->id }}"
                                                               name="is_active"
                                                               value="1"
                                                               {{ $variant->is_active ? 'checked' : '' }}>

                                                        <label class="form-check-label" for="edit_variant_active_{{ $variant->id }}">
                                                            Variante Ativa
                                                        </label>

                                                    </div>
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Cancelar
                                                    </button>

                                                    <button type="submit" class="btn btn-primary">
                                                        Salvar Alterações
                                                    </button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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
        </div>

        <!-- ================================================= -->
        <!-- Modal Criar Variante -->
        <!-- ================================================= -->

        <div class="modal fade"
             id="createVariantModal"
             tabindex="-1"
             aria-labelledby="createVariantModalLabel"
             aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('variants.store', ['product' => $product->id]) }}">   

                        @csrf
                        <!-- Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="createVariantModalLabel">
                                Nova Variante
                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                            </button>
                        </div>


                        <!-- Body -->
                        <div class="modal-body">
                            <!-- SKU -->
                            <div class="mb-3 text-start">
                                <label for="create_variant_sku" class="form-label">
                                    SKU
                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text"
                                       class="form-control"
                                       id="create_variant_sku"
                                       name="sku"
                                       required>

                            </div>


                            <!-- Preço e Estoque -->
                            <div class="row mb-3 text-start">
                                <!-- Preço -->
                                <div class="col-md-6">
                                    <label for="create_variant_price" class="form-label">
                                        Preço
                                        <span class="text-danger">*</span>

                                    </label>

                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control"
                                           id="create_variant_price"
                                           name="price"
                                           required>

                                </div>


                                <!-- Estoque -->
                                <div class="col-md-6">
                                    <label for="create_variant_stock" class="form-label">
                                        Estoque
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                           min="0"
                                           class="form-control"
                                           id="create_variant_stock"
                                           name="stock"
                                           required>

                                </div>
                            </div>


                            <!-- Status -->
                            <div class="form-check form-switch mt-3 text-start">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="create_variant_active"
                                       name="is_active"
                                       value="1"
                                       checked>

                                <label class="form-check-label"for="create_variant_active">
                                    Variante Ativa
                                </label>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button"class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit"class="btn btn-primary">
                                Salvar
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    const attributesData = @json($attributes);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('.variant-attribute-select')
        .forEach(function (attributeSelect) {

            attributeSelect.addEventListener('change', function () {

                const attributeId = this.value;

                const card = this.closest('.card');

                const optionSelect =
                    card.querySelector('.variant-option-select');

                // Limpa as opções atuais
                optionSelect.innerHTML = '';

                // Nenhum atributo selecionado
                if (!attributeId) {

                    optionSelect.disabled = true;

                    optionSelect.innerHTML =
                        '<option value="">Selecione primeiro o atributo...</option>';

                    return;
                }

                // Localiza o atributo
                const attribute = attributesData.find(function (item) {

                    return item.id == attributeId;

                });

                // Atributo não encontrado
                if (!attribute) {

                    optionSelect.disabled = true;

                    optionSelect.innerHTML =
                        '<option value="">Atributo inválido</option>';

                    return;
                }

                // Nenhuma opção cadastrada
                if (!attribute.options || attribute.options.length === 0) {

                    optionSelect.disabled = true;

                    optionSelect.innerHTML =
                        '<option value="">Nenhuma opção cadastrada</option>';

                    return;
                }

                // Habilita o select
                optionSelect.disabled = false;

                optionSelect.innerHTML =
                    '<option value="">Selecione uma opção...</option>';

                // Adiciona as opções do atributo
                attribute.options.forEach(function (option) {

                    const optionElement =
                        document.createElement('option');

                    optionElement.value = option.id;
                    optionElement.textContent = option.option;

                    optionSelect.appendChild(optionElement);

                });

            });

        });

});
</script>

@endsection