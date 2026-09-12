<!-- OFFCANVAS (Menu Lateral & Perfil) -->
<!-- data-bs-scroll="true" ativa o backscrolling | data-bs-backdrop="true" ativa o backdrop -->
<div class="offcanvas offcanvas-start offcanvas-sidebar bg-light text-dark" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel">
    
    <!-- Cabeçalho da Offcanvas -->
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title d-flex align-items-center" id="adminSidebarLabel">
            <i class="bi bi-menu-up me-2"></i> Menu
        </h5>
        <button type="button" class="btn-close btn-close-primary" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>

    <!-- Corpo da Offcanvas -->
    <div class="offcanvas-body d-flex flex-column justify-content-between p-3">
        
        <!-- 1. TELAS DISPONÍVEIS (Navegação) -->
        <div>
            <p class="text-uppercase fs-7 text-muted fw-bold mb-2">Navegação</p>

            <div class="list-group list-group-flush mb-4">

                {{-- Dashboard --}}
                {{--  
                <div>
                    <div class="d-flex align-items-center bg-light rounded mb-1">
                        <a href="{{ route('admin.panel') }}"
                        class="list-group-item list-group-item-action bg-light text-dark border-0 flex-grow-1 {{ request()->routeIs('admin.panel') ? 'fw-bold fs-5' : '' }}">
                            <i class="bi bi-house-door me-2"></i>
                            Dashboard
                        </a>

                        <button class="btn btn-sm border-0"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#submenuDashboard"
                                aria-expanded="false"
                                aria-controls="submenuDashboard">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>

                    <div class="collapse ms-3" id="submenuDashboard">
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-bar-chart me-2"></i>
                            Estatísticas
                        </a>

                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-graph-up me-2"></i>
                            Relatórios
                        </a>
                    </div>
                </div>
                --}}
                

                {{-- Usuários --}}
                {{-- 
                <div>
                    <div class="d-flex align-items-center bg-light rounded mb-1">
                        <a href="{{ route('users.index') }}"
                        class="list-group-item list-group-item-action bg-light text-dark border-0 flex-grow-1 {{ request()->routeIs('users.*') ? 'fw-bold fs-5' : '' }}">
                            <i class="bi bi-people me-2"></i>
                            Usuários
                        </a>

                        <button class="btn btn-sm border-0"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#submenuUsuarios"
                                aria-expanded="false"
                                aria-controls="submenuUsuarios">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>

                    <div class="collapse ms-3" id="submenuUsuarios">
                        <a href="{{ route('users.index') }}"
                        class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Listar usuários
                        </a>

                        <a href="#"
                        class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-person-plus me-2"></i>
                            Novo usuário
                        </a>
                    </div>
                </div>
                 --}}

                {{-- Produtos --}}
                <div>
                    <div class="d-flex align-items-center bg-light rounded mb-1">
                        <a href="{{ route('products.index') }}"
                        class="list-group-item list-group-item-action bg-light text-dark border-0 flex-grow-1 {{ request()->routeIs('attributes.*', 'products.*') ? 'fw-bold fs-5' : ''}}">
                            <i class="bi bi-box-seam me-2"></i>
                            Produtos
                        </a>

                        <button class="btn btn-sm border-0"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#submenuProdutos"
                                aria-expanded="false"
                                aria-controls="submenuProdutos">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>

                    <div class="collapse ms-3" id="submenuProdutos">
                        <a href="{{ route('products.index') }}"
                        class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-list me-2"></i>
                            Listar produtos
                        </a>

                        <a href="{{ route('attributes.index') }}" class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-tags me-2"></i>
                            Atributos
                        </a>
                    </div>
                </div>
                

                {{-- Pedidos --}}
                {{-- 
                <div>
                    <div class="d-flex align-items-center bg-light rounded mb-1">
                        <a href="{{ route('orders.index') }}"
                        class="list-group-item list-group-item-action bg-light text-dark border-0 flex-grow-1 {{ request()->routeIs('orders.*') ? 'fw-bold fs-5' : '' }}">
                            <i class="bi bi-cart me-2"></i>
                            Pedidos
                        </a>

                        <button class="btn btn-sm border-0"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#submenuPedidos"
                                aria-expanded="false"
                                aria-controls="submenuPedidos">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>

                    <div class="collapse ms-3" id="submenuPedidos">
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-clock me-2"></i>
                            Pendentes
                        </a>

                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-check-circle me-2"></i>
                            Concluídos
                        </a>
                    </div>
                </div>
                 --}}

                {{-- Configurações --}}
                {{-- 
                <div>
                    <div class="d-flex align-items-center bg-light rounded mb-1">
                        <a href="{{ route('configs.index') }}"
                        class="list-group-item list-group-item-action bg-light text-dark border-0 flex-grow-1 {{ request()->routeIs('configs.*') ? 'fw-bold fs-5' : '' }}">
                            <i class="bi bi-gear me-2"></i>
                            Configurações
                        </a>

                        <button class="btn btn-sm border-0"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#submenuConfigs"
                                aria-expanded="false"
                                aria-controls="submenuConfigs">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>

                    <div class="collapse ms-3" id="submenuConfigs">
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-sliders me-2"></i>
                            Preferências
                        </a>

                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <i class="bi bi-shield-lock me-2"></i>
                            Permissões
                        </a>
                    </div>
                </div>
                --}}

            </div>
        </div>

        <!-- 2. DADOS SIMPLES DO USUÁRIO LOGADO -->
        <div class="card bg-secondary bg-opacity-25 border-secondary text-white p-3 rounded">
            <div class="d-flex align-items-center me-2">
                <i class="bi bi-person-badge fs-2 me-3 text-primary"></i>
                <div class="overflow-hidden">
                    <h6 class="mb-0 text-truncate fw-bold">{{ Auth::user()->name ?? 'Usuário' }}</h6>
                    <small class="text-muted d-block text-truncate">{{ Auth::user()->email ?? 'usuario@email.com' }}</small>
                    <span class="badge bg-success mt-1">Admin</span>
                </div>
            </div>
        </div>

    </div>
</div>