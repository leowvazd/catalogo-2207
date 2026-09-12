<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('title')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .offcanvas-sidebar {
            width: 280px;
        }
    </style>

    <link rel="shortcut icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
</head>
<body class="bg-light py-4">
    <header>
        <!-- NAVBAR TOPO -->
        <nav class="navbar navbar-dark bg-dark sticky-top shadow-sm">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <!-- Botão que ativa o Offcanvas à esquerda -->
                    <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <a class="navbar-brand fw-bold mb-0" href="#">Painel Admin</a>
                </div>

                <!-- Dados Rápidos do Usuário na Navbar -->
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5 me-1"></i>
                        <span class="d-none d-sm-inline">{{ mb_strtoupper((Auth::user()->name ?? 'usuário'), 'UTF-8') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <!-- Formulário de Logout do Laravel -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-1"></i> Desconectar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    @include('admin.partials.sidebar')

    @yield('content')
</body>
<footer>
    @yield('footer')
</footer>


