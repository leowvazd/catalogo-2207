<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Bem-vindo</title>

</head>
<body class="bg-light">

    <!-- 1. NAVBAR FIXO -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold text-dark" href="{{ route('home') }}">
                Lessenzza
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                <!-- CARRINHO E AUTENTICAÇÃO -->
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <!-- Carrinho -->
                    <li class="nav-item">
                        <a href="{{ route('cart.index') }}"
                            class="btn btn-outline-dark position-relative border-0"
                            aria-label="Carrinho">

                            <i class="bi bi-cart3 fs-5"></i>

                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartItemCount ?? 0 }}
                            </span>
                        </a>
                    </li>

                    <div class="vr d-none d-lg-block bg-secondary mx-1" style="height: 25px;"></div>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ÁREA PRINCIPAL -->
    <main class="container my-4">
        
        <!-- 3. CABEÇALHO DA LISTAGEM (Contador, Filtros, Ordenação) -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Botão Filtros (Abre Offcanvas) -->
                    <button class="btn btn-outline-dark d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                        <i class="bi bi-funnel"></i> Filtros
                    </button>
                    
                    <!-- Contador de Resultados -->
                    <span class="text-muted small">
                        Exibindo <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> de <strong>{{ $products->total() }}</strong> produtos
                    </span>
                </div>

                <div>
                    <!-- 2. BARRA DE PESQUISA (GET search) -->
                    <form action="" method="GET" class="d-flex mx-auto my-2 my-lg-0 w-100 max-w-50" style="max-width: 500px;">
                        <!-- Preserva filtros anteriores na busca simples -->
                        @if(request('min_price')) 
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}"> 
                        @endif
                        @if(request('max_price')) 
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}"> 
                        @endif
                        @if(request('sort')) 
                            <input type="hidden" name="sort" value="{{ request('sort') }}"> 
                        @endif

                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar produtos..." value="{{ request('search') }}" aria-label="Pesquisar">
                            <button class="btn btn-dark" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Ordenação com submissão automática via Formulário GET -->
                <form action="{{ route('home') }}" method="GET" class="d-flex align-items-center gap-2">
                    <!-- Preserva parâmetros existentes ao ordenar -->
                    @if(request('search')) 
                        <input type="hidden" name="search" value="{{ request('search') }}"> 
                    @endif
                    @if(request('min_price'))
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}"> 
					@endif
                    @if(request('max_price')) 
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}"> 
					@endif

                    <label for="sortSelect" class="form-label mb-0 text-nowrap small text-muted">Ordenar por:</label>
                    <select name="sort" id="sortSelect" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="relevancia" {{ request('sort') == 'relevancia' ? 'selected' : '' }}>Mais relevantes</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Menor preço</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Maior preço</option>
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Mais recentes</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nome: A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nome: Z-A</option>
                    </select>
                </form>

            </div>
        </div>

        <!-- 5. GRID DE PRODUTOS -->
        <div class="row g-3 g-md-4">

            @forelse($products as $product)

                @php
                    $variants = $product->variants;
                    $firstVariant = $variants->first();

                    $firstImage = $firstVariant?->images->first();

                    $minPrice = $variants->min('price');
                    $maxPrice = $variants->max('price');
                @endphp

                <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                    <div class="card h-100 border-0 shadow-sm product-card">

                        {{-- IMAGEM --}}
                        <a href="{{ route('shop.products.show', $product) }}"
                        class="text-decoration-none">

                            <div class="product-img-wrapper rounded-top">

                                @if($firstImage)

                                    <img
                                        src="{{ asset('storage/products/variants/' . $firstImage->filename) }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                    >

                                @else

                                    <div class="d-flex flex-column
                                                align-items-center
                                                justify-content-center
                                                text-muted
                                                h-100">

                                        <i class="bi bi-image fs-1"></i>

                                        <small class="mt-2">
                                            Sem imagem
                                        </small>

                                    </div>

                                @endif

                            </div>

                        </a>

                        {{-- INFORMAÇÕES --}}
                        <div class="card-body d-flex flex-column">

                            {{-- Nome --}}
                            <a href="{{ route('shop.products.show', $product) }}"
                            class="text-decoration-none text-dark">

                                <h5
                                    class="card-title text-truncate fs-6 fw-bold mb-1"
                                    title="{{ $product->name }}"
                                >
                                    {{ $product->name }}
                                </h5>

                            </a>

                            {{-- Descrição --}}
                            <p
                                class="card-text text-muted small mb-2"
                                style="
                                    display: -webkit-box;
                                    -webkit-line-clamp: 2;
                                    -webkit-box-orient: vertical;
                                    overflow: hidden;
                                "
                            >
                                {{ $product->description }}
                            </p>

                            @if($variants->count() > 0)

                                {{-- PREÇO --}}
                                <div class="my-2">

                                    @if($variants->count() > 1)

                                        <small class="text-muted d-block">
                                            A partir de
                                        </small>

                                    @endif

                                    <span class="fs-5 fw-bold text-primary">

                                        R$
                                        {{ number_format(
                                            $minPrice / 100,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                </div>

                                {{-- AÇÕES --}}
                                <div class="d-grid gap-2 mt-auto">

                                    {{-- Visualizar --}}
                                    <a
                                        href="{{ route('shop.products.show', $product) }}"
                                        class="btn btn-outline-secondary btn-sm"
                                    >

                                        <i class="bi bi-eye me-1"></i>

                                        Visualizar

                                    </a>

                                    {{-- UMA ÚNICA VARIANTE --}}
                                    @if($variants->count() === 1)

                                        <form
                                            method="POST"
                                            action="{{ route('cart.add', $firstVariant) }}"
                                        >

                                            @csrf

                                            <input
                                                type="hidden"
                                                name="quantity"
                                                value="1"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-primary btn-sm w-100"
                                            >

                                                <i class="bi bi-cart-plus me-1"></i>

                                                Adicionar ao carrinho

                                            </button>

                                        </form>

                                    {{-- VÁRIAS VARIANTES --}}
                                    @else
                                        <a href="{{ route('shop.products.show', $product) }}"
                                            class="btn btn-primary btn-sm">

                                            <i class="bi bi-ui-checks-grid me-1"></i>
                                            Escolher opções
                                        </a>
                                    @endif
                                </div>

                            @else

                                <div class="mt-auto">

                                    <span class="badge bg-secondary">
                                        Indisponível
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center py-5">

                    <i class="bi bi-search fs-1 text-muted"></i>

                    <h4 class="mt-3 text-muted">
                        Nenhum produto encontrado
                    </h4>

                    <p class="text-secondary">
                        Tente mudar os termos de busca
                        ou remover os filtros aplicados.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="btn btn-primary btn-sm mt-2"
                    >
                        Limpar busca e filtros
                    </a>

                </div>

            @endforelse

        </div>

        <!-- 6. PAGINAÇÃO DA LISTAGEM -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>

    </main>

    <!-- 4. PAINEL OFFCANVAS DE FILTROS -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel"><i class="bi bi-funnel me-2"></i>Filtros</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body">
            <form action="{{ route('home') }}" method="GET">
                <!-- Preserva a ordenação e a busca se aplicadas -->
                @if(request('search')) 
                    <input type="hidden" name="search" value="{{ request('search') }}"> 
                @endif

                @if(request('sort')) 
                    <input type="hidden" name="sort" value="{{ request('sort') }}"> 
                @endif

                <!-- Faixa de Preço -->
                <div class="mb-4">
                    <label class="form-label fw-bold small">Faixa de Preço (R$)</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" step="0.01" name="min_price" class="form-control" placeholder="Mínimo" value="{{ request('min_price') }}">
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="max_price" class="form-control" placeholder="Máximo" value="{{ request('max_price') }}">
                        </div>
                    </div>
                </div>

                {{-- 
                 Disponibilidade 
                <div class="mb-4">
                    <label class="form-label fw-bold small">Disponibilidade</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="in_stock" id="inStockCheck" value="1" {{ request('in_stock')?'checked':'' }}>
                        <label class="form-check-label small" for="inStockCheck">
                            Apenas produtos em estoque
                        </label>
                    </div>
                </div>
                --}}
            </form>
        </div>
    </div>
</body>
</html>