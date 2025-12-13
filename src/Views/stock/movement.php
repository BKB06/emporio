<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Nova Movimentação de Estoque</h1>
            <a href="/stock" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
        
        <?php
        use App\Core\Session;
        if ($errors = Session::flash('errors')):
        ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $fieldErrors): ?>
                    <?php foreach ($fieldErrors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if ($error = Session::flash('error')): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/stock/movement">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Produto *</label>
                        <select class="form-select" id="product_id" name="product_id" required>
                            <option value="">Selecione um produto...</option>
                            <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>">
                                <?= htmlspecialchars($product['name']) ?> 
                                (SKU: <?= htmlspecialchars($product['sku']) ?>) 
                                - Estoque atual: <?= $product['quantity'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipo de Movimentação *</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Selecione...</option>
                                <option value="entrada">Entrada (Compra, Devolução)</option>
                                <option value="saida">Saída (Venda, Perda)</option>
                                <option value="ajuste">Ajuste (Correção de Estoque)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">Quantidade *</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Motivo</label>
                        <input type="text" class="form-control" id="reason" name="reason" 
                               placeholder="Ex: Compra do fornecedor X, Venda NF 1234...">
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Observações</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Informações adicionais sobre a movimentação..."></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Atenção:</strong> Esta ação irá alterar a quantidade em estoque do produto.
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/stock" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Registrar Movimentação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
