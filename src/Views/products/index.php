<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Produtos</h1>
            <a href="/products/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Produto
            </a>
        </div>
        
        <?php
        use App\Core\Session;
        if ($success = Session::flash('success')):
        ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <!-- Busca -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="/products">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" id="searchInput" 
                               placeholder="Buscar por nome, SKU ou código de barras..." 
                               value="<?= htmlspecialchars($search ?? '') ?>">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tabela -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Fornecedor</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Nenhum produto encontrado.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><code><?= htmlspecialchars($product['sku']) ?></code></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['category_name'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($product['supplier_name'] ?? '-') ?></td>
                                    <td>
                                        <?php
                                        $badge = 'success';
                                        if ($product['quantity'] <= $product['min_quantity']) {
                                            $badge = 'danger';
                                        } elseif ($product['quantity'] <= $product['min_quantity'] * 1.5) {
                                            $badge = 'warning';
                                        }
                                        ?>
                                        <span class="badge bg-<?= $badge ?>"><?= $product['quantity'] ?></span>
                                    </td>
                                    <td>R$ <?= number_format($product['unit_price'], 2, ',', '.') ?></td>
                                    <td>
                                        <span class="badge bg-<?= $product['status'] === 'ativo' ? 'success' : 'secondary' ?>">
                                            <?= htmlspecialchars($product['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="/products/<?= $product['id'] ?>" class="btn btn-info" title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/products/<?= $product['id'] ?>/edit" class="btn btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="/products/<?= $product['id'] ?>/delete" class="d-inline">
                                                <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                <?php if (isset($pagination) && $pagination['lastPage'] > 1): ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pagination['lastPage']; $i++): ?>
                        <li class="page-item <?= $i === $pagination['page'] ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
