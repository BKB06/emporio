<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Editar Produto</h1>
            <a href="/products" class="btn btn-secondary">
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
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/products/<?= $product['id'] ?>/update">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($product['sku']) ?>" disabled>
                            <small class="text-muted">O SKU não pode ser alterado</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="barcode" class="form-label">Código de Barras</label>
                            <input type="text" class="form-control" id="barcode" name="barcode" 
                                   value="<?= htmlspecialchars($product['barcode'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Categoria *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label">Fornecedor *</label>
                            <select class="form-select" id="supplier_id" name="supplier_id" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($suppliers as $supplier): ?>
                                <option value="<?= $supplier['id'] ?>" <?= $supplier['id'] == $product['supplier_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($supplier['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantidade Atual</label>
                            <input type="text" class="form-control" value="<?= $product['quantity'] ?>" disabled>
                            <small class="text-muted">Use movimentação de estoque para alterar</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="min_quantity" class="form-label">Quantidade Mínima *</label>
                            <input type="number" class="form-control" id="min_quantity" name="min_quantity" 
                                   value="<?= $product['min_quantity'] ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="unit_price" class="form-label">Preço Unitário *</label>
                            <input type="number" class="form-control" id="unit_price" name="unit_price" 
                                   step="0.01" value="<?= $product['unit_price'] ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="ativo" <?= $product['status'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                            <option value="inativo" <?= $product['status'] === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/products" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
