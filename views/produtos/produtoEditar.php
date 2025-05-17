<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Editar Produto</h2>

    <form action="/?rota=produto/atualizar" method="POST">
        <input type="hidden" name="id" value="<?= $produto->id ?>">

        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Produto</label>
            <input type="text" name="nome" class="form-control" value="<?= $produto->nome ?>" required>
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço (R$)</label>
            <input type="number" step="0.01" name="preco" class="form-control" value="<?= $produto->preco ?>" required>
        </div>

        <h4 class="mt-5">Variações</h4>
        <?php if (empty($variacoes)): ?>
            <p class="text-muted">Nenhuma variação cadastrada.</p>
        <?php else: ?>
            <?php foreach ($variacoes as $v): ?>
                <div class="row mb-2 align-items-center">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="variacoes[<?= $v->id ?>][nome]" value="<?= htmlspecialchars($v->nome) ?>" placeholder="Nome da variação">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="variacoes[<?= $v->id ?>][quantidade]" value="<?= $v->quantidade ?>" placeholder="Quantidade em estoque">
                    </div>
                    <div class="col-md-2">
                        <a href="/?rota=variacao/excluir&id=<?= $v->id ?>&produto_id=<?= $produto->id ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Excluir essa variação?')">🗑️</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h5 class="mt-4">Nova variação</h5>
        <div class="row mb-4">
            <div class="col-md-5">
                <input type="text" class="form-control" name="nova_variacao[nome]" placeholder="Nome da nova variação">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="nova_variacao[quantidade]" placeholder="Quantidade em estoque">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="/?rota=produto/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
