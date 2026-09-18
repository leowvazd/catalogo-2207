<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Página não encontrada - Erro 404</title>


    <style>
        body {
            background-color: #f8f9fa;
        }
        .offcanvas-sidebar {
            width: 280px;
        }
    </style>


</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100 m-0">

    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Ícone ou Número de Erro -->
                <div class="display-1 fw-bold text-primary mb-3">404</div>
                
                <!-- Mensagem amigável -->
                <h1 class="h3 fw-semibold text-dark mb-2">Ops! Página não encontrada.</h1>
                <p class="text-muted mb-4">
                    Parece que você seguiu um link incorreto ou a página que você está procurando foi removida, renomeada ou temporariamente indisponível.
                </p>

                <!-- Botão de retorno -->
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                    Voltar para a Página Inicial
                </a>
            </div>
        </div>
    </div>

</body>
</html>