<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página não encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            color: white;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            line-height: 1;
            text-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }
        .error-message {
            font-size: 24px;
            margin: 20px 0;
        }
        .btn-home {
            margin-top: 30px;
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 50px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-exclamation-triangle-fill" style="font-size: 100px; opacity: 0.8;"></i>
        <div class="error-code">404</div>
        <div class="error-message">Página não encontrada</div>
        <p>A página que você está procurando não existe ou foi movida.</p>
        <a href="/dashboard" class="btn btn-light btn-home">
            <i class="bi bi-house-door"></i> Voltar ao Dashboard
        </a>
    </div>
</body>
</html>
