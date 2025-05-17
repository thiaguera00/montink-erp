<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Produtos Cadastrados</h2>

    <?php if (isset($_GET['sucesso'])): ?>
        <?php if ($_GET['sucesso'] == 1): ?>
            <div class="alert alert-success">Produto salvo com sucesso!</div>
        <?php elseif ($_GET['sucesso'] == 2): ?>
            <div class="alert alert-info">Produto atualizado com sucesso!</div>
        <?php elseif ($_GET['sucesso'] == 3): ?>
            <div class="alert alert-danger">Produto excluído com sucesso!</div>
        <?php elseif ($_GET['sucesso'] == 4): ?>
            <div class="alert alert-success">Variação adicionada com sucesso!</div>
        <?php endif; ?>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Variações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td>
                        <?php if (empty($p['variacoes'])): ?>
                            <span class="text-muted">Nenhuma</span>
                        <?php else: ?>
                            <?php foreach ($p['variacoes'] as $v): ?>
                                <span class="badge bg-secondary me-1">
                                    <?= htmlspecialchars($v['nome']) ?> 
                                    (<?= $v['quantidade'] ?>)
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/?rota=produto/editar&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                        <a href="/?rota=produto/excluir&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Tem certeza que deseja excluir?');">🗑️</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/?rota=produto/form" class="btn btn-primary">+ Novo Produto</a>
    <a href="/?rota=variacao/form" class="btn btn-secondary ms-2">+ Adicionar Variação</a>
</body>
</html>
