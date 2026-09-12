<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema em Manutenção</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <!-- Ícone ou Indicador de Manutenção (Exemplo com SVG de engrenagem) -->
                <div class="mb-4">
                    <i class="bi bi-tools fs-2 d-block mb-2"></i>
                </div>

                <!-- Título e Mensagem -->
                <h1 class="h3 fw-semibold text-dark mb-2">Voltamos em breve!</h1>
                <p class="text-muted mb-4">
                    Estamos realizando melhorias e atualizações no sistema para oferecer uma experiência ainda melhor. Por favor, tente novamente em alguns instantes.
                </p>

                <!-- Aviso Opcional -->
                <div class="alert alert-warning py-2 small" role="alert">
                    Agradecemos pela sua paciência e compreensão.
                </div>
            </div>
        </div>
    </div>

</body>
</html>