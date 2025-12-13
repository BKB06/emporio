<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <h1 class="mb-4">Dashboard</h1>
        
        <?php
        use App\Core\Session;
        if ($success = Session::flash('success')):
        ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <!-- Cards de estatísticas -->
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card primary">
                    <h3><?= $totalProducts ?></h3>
                    <p><i class="bi bi-box"></i> Total de Produtos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card success">
                    <h3>R$ <?= number_format($totalValue, 2, ',', '.') ?></h3>
                    <p><i class="bi bi-currency-dollar"></i> Valor em Estoque</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card warning">
                    <h3><?= count($lowStock) ?></h3>
                    <p><i class="bi bi-exclamation-triangle"></i> Estoque Baixo</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card info">
                    <h3><?= count($recentMovements) ?></h3>
                    <p><i class="bi bi-arrow-left-right"></i> Movimentações Recentes</p>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <!-- Produtos com estoque baixo -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-exclamation-triangle text-warning"></i> Produtos com Estoque Baixo
                    </div>
                    <div class="card-body">
                        <?php if (empty($lowStock)): ?>
                            <p class="text-muted">Nenhum produto com estoque baixo.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Mínimo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($lowStock, 0, 5) as $product): ?>
                                        <tr>
                                            <td>
                                                <a href="/products/<?= $product['id'] ?>">
                                                    <?= htmlspecialchars($product['name']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger"><?= $product['quantity'] ?></span>
                                            </td>
                                            <td><?= $product['min_quantity'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if (count($lowStock) > 5): ?>
                            <a href="/products" class="btn btn-sm btn-outline-primary">
                                Ver todos os produtos <i class="bi bi-arrow-right"></i>
                            </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Últimas movimentações -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-clock-history"></i> Últimas Movimentações
                    </div>
                    <div class="card-body">
                        <?php if (empty($recentMovements)): ?>
                            <p class="text-muted">Nenhuma movimentação recente.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Tipo</th>
                                            <th>Qtd</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentMovements as $movement): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($movement['product_name']) ?></td>
                                            <td>
                                                <?php
                                                $badge = 'secondary';
                                                if ($movement['type'] === 'entrada') $badge = 'success';
                                                if ($movement['type'] === 'saida') $badge = 'danger';
                                                ?>
                                                <span class="badge bg-<?= $badge ?>">
                                                    <?= htmlspecialchars($movement['type']) ?>
                                                </span>
                                            </td>
                                            <td><?= $movement['quantity'] ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($movement['created_at'])) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <a href="/stock" class="btn btn-sm btn-outline-primary">
                                Ver histórico completo <i class="bi bi-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
