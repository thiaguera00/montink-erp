<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
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
        <?php elseif (isset($_GET['sucesso']) && $_GET['sucesso'] == 6): ?>
            <div class="alert alert-success">Produto adicionado ao carrinho!</div>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
        <div class="alert alert-warning">Você precisa escolher uma variação antes de comprar.</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle container py-4 text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Variações</th>
                <th>Quantidade</th>
                <th>Ações</th>
                <th>Comprar</th>
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
                                <div class="mb-1">
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($v['nome']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($p['variacoes'])): ?>
                            <?php foreach ($p['variacoes'] as $v): ?>
                                <div class="mb-1">
                                    <span class="badge bg-secondary">
                                        <?= $v['quantidade'] ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/?rota=produto/editar&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                        <a href="/?rota=produto/excluir&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Tem certeza que deseja excluir?');">🗑️</a>
                    </td>
                    <td>
                        <?php if (!empty($p['variacoes'])): ?>
                            <form action="/?rota=carrinho/adicionar" method="POST" class="d-inline mt-1">
                                <input type="hidden" name="produto_id" value="<?= $p['id'] ?>">
                                <select name="variacao_id" class="form-select form-select-sm d-inline w-auto" required>
                                    <option value="">Variação</option>
                                    <?php foreach ($p['variacoes'] as $v): ?>
                                        <?php if ($v['quantidade'] > 0): ?>
                                            <option value="<?= $v['id'] ?>">
                                                <?= htmlspecialchars($v['nome']) ?> (<?= $v['quantidade'] ?>)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-sm btn-success">🛒</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/?rota=produto/form" class="btn btn-primary">+ Novo Produto</a>
    <a href="/?rota=cupom/form" class="btn btn-secondary ms-2">Novo Cupom</a>
</div>
</body>
</html>
