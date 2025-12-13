<!-- Sidebar -->
<div class="sidebar">
    <nav class="nav flex-column">
        <a class="nav-link" href="/dashboard">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-link" href="/products">
            <i class="bi bi-box"></i> Produtos
        </a>
        <a class="nav-link" href="/categories">
            <i class="bi bi-tags"></i> Categorias
        </a>
        <a class="nav-link" href="/suppliers">
            <i class="bi bi-truck"></i> Fornecedores
        </a>
        <a class="nav-link" href="/stock">
            <i class="bi bi-arrow-left-right"></i> Estoque
        </a>
        <a class="nav-link" href="/reports">
            <i class="bi bi-file-earmark-text"></i> Relatórios
        </a>
        <?php
        use App\Core\Auth;
        if (Auth::isAdmin()):
        ?>
        <a class="nav-link" href="/users">
            <i class="bi bi-people"></i> Usuários
        </a>
        <?php endif; ?>
    </nav>
</div>
