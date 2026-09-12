@extends('admin.layouts.app')
@section('title') 
    <title>Painel do Administrador</title>
@section('content')

    <!-- CONTEÚDO PRINCIPAL DA PÁGINA -->
    <main class="container my-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h1 class="h3 fw-bold mb-3">Bem-vindo ao Painel</h1>
                        <p class="text-secondary">
                            Clique no botão <i class="bi bi-list border p-1 rounded bg-light"></i> na barra superior para abrir o menu lateral (Offcanvas).
                        </p>
                        
                        <hr class="my-4">

                        <!-- Exemplo de conteúdo do painel -->
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white border-0">
                                    <div class="card-body">
                                        <h5 class="card-title">Usuários Registrados</h5>
                                        <p class="fs-3 fw-bold mb-0">120</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white border-0">
                                    <div class="card-body">
                                        <h5 class="card-title">Vendas do Mês</h5>
                                        <p class="fs-3 fw-bold mb-0">R$ 15.400</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-dark border-0">
                                    <div class="card-body">
                                        <h5 class="card-title">Tarefas Pendentes</h5>
                                        <p class="fs-3 fw-bold mb-0">5</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection