<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Histórico de Estoque</h1>
            <a href="/stock/movement" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nova Movimentação
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
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produto</th>
                                <th>SKU</th>
                                <th>Tipo</th>
                                <th>Quantidade</th>
                                <th>Motivo</th>
                                <th>Usuário</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($movements)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Nenhuma movimentação encontrada.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($movements as $movement): ?>
                                <tr>
                                    <td><?= $movement['id'] ?></td>
                                    <td><?= htmlspecialchars($movement['product_name']) ?></td>
                                    <td><code><?= htmlspecialchars($movement['sku']) ?></code></td>
                                    <td>
                                        <?php
                                        $badge = 'secondary';
                                        $icon = 'arrow-repeat';
                                        if ($movement['type'] === 'entrada') {
                                            $badge = 'success';
                                            $icon = 'arrow-down-circle';
                                        } elseif ($movement['type'] === 'saida') {
                                            $badge = 'danger';
                                            $icon = 'arrow-up-circle';
                                        }
                                        ?>
                                        <span class="badge bg-<?= $badge ?>">
                                            <i class="bi bi-<?= $icon ?>"></i>
                                            <?= htmlspecialchars($movement['type']) ?>
                                        </span>
                                    </td>
                                    <td><?= $movement['quantity'] ?></td>
                                    <td><?= htmlspecialchars($movement['reason'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($movement['username']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($movement['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
