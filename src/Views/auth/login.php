<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Empório</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <i class="bi bi-box-seam" style="font-size: 3rem; color: #667eea;"></i>
                <h2 class="mt-3">Sistema Empório</h2>
                <p class="text-muted">Faça login para continuar</p>
            </div>
            
            <?php
            use App\Core\Session;
            if ($error = Session::flash('error')):
            ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success = Session::flash('success')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="/login">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right"></i> Entrar
                </button>
            </form>
            
            <div class="text-center">
                <p class="text-muted mb-0">Não tem uma conta? <a href="/register">Registre-se</a></p>
            </div>
            
            <hr class="my-4">
            
            <div class="text-center">
                <small class="text-muted">
                    <strong>Credenciais padrão:</strong><br>
                    admin@emporio.com / admin123
                </small>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
