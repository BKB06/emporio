<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Detalhes do Produto</h1>
            <div>
                <a href="/products/<?= $product['id'] ?>/edit" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="/products" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informações do Produto</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>SKU:</strong><br>
                                <code><?= htmlspecialchars($product['sku']) ?></code>
                            </div>
                            <div class="col-md-6">
                                <strong>Código de Barras:</strong><br>
                                <?= htmlspecialchars($product['barcode'] ?? '-') ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <strong>Nome:</strong><br>
                            <?= htmlspecialchars($product['name']) ?>
                        </div>
                        
                        <div class="mb-3">
                            <strong>Descrição:</strong><br>
                            <?= htmlspecialchars($product['description'] ?? 'Sem descrição') ?>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Categoria:</strong><br>
                                <?= htmlspecialchars($product['category_name'] ?? '-') ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Fornecedor:</strong><br>
                                <?= htmlspecialchars($product['supplier_name'] ?? '-') ?>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Quantidade:</strong><br>
                                <span class="badge bg-<?= $product['quantity'] <= $product['min_quantity'] ? 'danger' : 'success' ?> fs-5">
                                    <?= $product['quantity'] ?>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <strong>Quantidade Mínima:</strong><br>
                                <?= $product['min_quantity'] ?>
                            </div>
                            <div class="col-md-4">
                                <strong>Preço Unitário:</strong><br>
                                R$ <?= number_format($product['unit_price'], 2, ',', '.') ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <strong>Status:</strong><br>
                            <span class="badge bg-<?= $product['status'] === 'ativo' ? 'success' : 'secondary' ?>">
                                <?= htmlspecialchars($product['status']) ?>
                            </span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Criado em:</strong><br>
                                <?= date('d/m/Y H:i', strtotime($product['created_at'])) ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Atualizado em:</strong><br>
                                <?= date('d/m/Y H:i', strtotime($product['updated_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ações Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <a href="/stock/movement?product_id=<?= $product['id'] ?>" class="btn btn-success w-100 mb-2">
                            <i class="bi bi-plus-circle"></i> Entrada de Estoque
                        </a>
                        <a href="/stock/movement?product_id=<?= $product['id'] ?>" class="btn btn-danger w-100 mb-2">
                            <i class="bi bi-dash-circle"></i> Saída de Estoque
                        </a>
                        <a href="/stock?product_id=<?= $product['id'] ?>" class="btn btn-info w-100">
                            <i class="bi bi-clock-history"></i> Ver Histórico
                        </a>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Resumo</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Valor Total:</strong><br>
                            <h4 class="text-primary">
                                R$ <?= number_format($product['quantity'] * $product['unit_price'], 2, ',', '.') ?>
                            </h4>
                        </div>
                        
                        <?php if ($product['quantity'] <= $product['min_quantity']): ?>
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Atenção!</strong><br>
                            Estoque está abaixo do mínimo.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
