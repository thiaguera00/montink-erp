<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="/public/imgs/logo-montink.png" alt="logo" height="40">
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/?rota=produto/form">Adicionar Produto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/?rota=cupom/form">Adicionar Cupom</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/?rota=produto/listar">Produtos</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-dark ms-3" href="/?rota=carrinho/ver">🛒 Ver Carrinho</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">


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
                        <input type="text" class="form-control"
                            name="variacoes[<?= $v->id ?>][nome]"
                            value="<?= htmlspecialchars($v->nome) ?>"
                            placeholder="Nome da variação">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control"
                            name="variacoes[<?= $v->id ?>][quantidade]"
                            value="<?= $v->quantidade ?>"
                            placeholder="Quantidade em estoque">
                    </div>
                    <div class="col-md-2">
                        <a href="/?rota=variacao/excluir&id=<?= $v->id ?>&produto_id=<?= $produto->id ?>"
                        class="btn btn-sm btn-danger"
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
</div>
</body>
</html>
