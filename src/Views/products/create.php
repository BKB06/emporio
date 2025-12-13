<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Novo Produto</h1>
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
                <form method="POST" action="/products">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU *</label>
                            <input type="text" class="form-control" id="sku" name="sku" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="barcode" class="form-label">Código de Barras</label>
                            <input type="text" class="form-control" id="barcode" name="barcode">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Categoria *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>">
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
                                <option value="<?= $supplier['id'] ?>">
                                    <?= htmlspecialchars($supplier['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Quantidade Inicial *</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="min_quantity" class="form-label">Quantidade Mínima *</label>
                            <input type="number" class="form-control" id="min_quantity" name="min_quantity" value="10" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="unit_price" class="form-label">Preço Unitário *</label>
                            <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="ativo" selected>Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/products" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
