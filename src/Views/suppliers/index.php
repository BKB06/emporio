<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Fornecedores</h1>
            <a href="/suppliers/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Fornecedor
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
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($suppliers)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Nenhum fornecedor encontrado.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td><?= $supplier['id'] ?></td>
                                    <td><?= htmlspecialchars($supplier['name']) ?></td>
                                    <td><?= htmlspecialchars($supplier['cnpj'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($supplier['email'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($supplier['phone'] ?? '-') ?></td>
                                    <td><?= date('d/m/Y', strtotime($supplier['created_at'])) ?></td>
                                    <td>
                                        <form method="POST" action="/suppliers/<?= $supplier['id'] ?>/delete" class="d-inline">
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
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
