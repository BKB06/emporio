<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <h1 class="mb-4">Relatórios</h1>
        
        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="/reports">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Tipo de Relatório</label>
                            <select class="form-select" id="type" name="type" onchange="this.form.submit()">
                                <option value="stock" <?= $type === 'stock' ? 'selected' : '' ?>>Estoque Atual</option>
                                <option value="low_stock" <?= $type === 'low_stock' ? 'selected' : '' ?>>Estoque Baixo</option>
                                <option value="movements" <?= $type === 'movements' ? 'selected' : '' ?>>Movimentações</option>
                            </select>
                        </div>
                        
                        <?php if ($type === 'movements'): ?>
                        <div class="col-md-3 mb-3">
                            <label for="start_date" class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="<?= htmlspecialchars($startDate) ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="end_date" class="form-label">Data Final</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="<?= htmlspecialchars($endDate) ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-filter"></i> Filtrar
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Botão de exportação -->
        <div class="mb-3">
            <a href="/reports/pdf?type=<?= $type ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>" 
               class="btn btn-danger">
                <i class="bi bi-file-pdf"></i> Exportar PDF
            </a>
        </div>
        
        <!-- Relatório de Estoque Atual -->
        <?php if ($type === 'stock'): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-box"></i> Estoque Atual - Todos os Produtos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Produto</th>
                                <th>Categoria</th>
                                <th>Fornecedor</th>
                                <th>Quantidade</th>
                                <th>Preço Unitário</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalValue = 0;
                            foreach ($data as $product):
                                $itemValue = $product['quantity'] * $product['unit_price'];
                                $totalValue += $itemValue;
                            ?>
                            <tr>
                                <td><code><?= htmlspecialchars($product['sku']) ?></code></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['category_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($product['supplier_name'] ?? '-') ?></td>
                                <td><?= $product['quantity'] ?></td>
                                <td>R$ <?= number_format($product['unit_price'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($itemValue, 2, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-<?= $product['status'] === 'ativo' ? 'success' : 'secondary' ?>">
                                        <?= htmlspecialchars($product['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="table-info fw-bold">
                                <td colspan="6" class="text-end">VALOR TOTAL:</td>
                                <td colspan="2">R$ <?= number_format($totalValue, 2, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Relatório de Estoque Baixo -->
        <?php if ($type === 'low_stock'): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle text-warning"></i> Produtos com Estoque Baixo</h5>
            </div>
            <div class="card-body">
                <?php if (empty($data)): ?>
                    <p class="text-muted text-center">Nenhum produto com estoque baixo no momento.</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Produto</th>
                                <th>Categoria</th>
                                <th>Quantidade Atual</th>
                                <th>Quantidade Mínima</th>
                                <th>Diferença</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $product): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($product['sku']) ?></code></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['category_name'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-danger"><?= $product['quantity'] ?></span>
                                </td>
                                <td><?= $product['min_quantity'] ?></td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <?= $product['min_quantity'] - $product['quantity'] ?> unidades
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Relatório de Movimentações -->
        <?php if ($type === 'movements'): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-arrow-left-right"></i> 
                    Movimentações - <?= date('d/m/Y', strtotime($startDate)) ?> até <?= date('d/m/Y', strtotime($endDate)) ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data/Hora</th>
                                <th>Produto</th>
                                <th>SKU</th>
                                <th>Tipo</th>
                                <th>Quantidade</th>
                                <th>Motivo</th>
                                <th>Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Nenhuma movimentação encontrada no período.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($data as $movement): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($movement['created_at'])) ?></td>
                                    <td><?= htmlspecialchars($movement['product_name']) ?></td>
                                    <td><code><?= htmlspecialchars($movement['sku']) ?></code></td>
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
                                    <td><?= htmlspecialchars($movement['reason'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($movement['username']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
