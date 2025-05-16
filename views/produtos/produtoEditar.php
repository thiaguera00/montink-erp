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

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="/?rota=produto/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
