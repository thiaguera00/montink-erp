<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Variação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Nova Variação</h2>

    <form action="/?rota=variacao/salvar" method="POST">
        <!-- Produto -->
        <div class="mb-3">
            <label for="produto_id" class="form-label">Produto</label>
            <select name="produto_id" class="form-select" required>
                <option value="">Selecione...</option>
                <?php foreach ($produtos as $p): ?>
                    <option value="<?= $p->id ?>"><?= htmlspecialchars($p->nome) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Nome da Variação -->
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Variação</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <!-- Quantidade em Estoque -->
        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade em Estoque</label>
            <input type="number" name="quantidade" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar Variação</button>
        <a href="/?rota=produto/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
