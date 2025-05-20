<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
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

   <h2>Carrinho de Compras</h2>
    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'cupom_nao_aplicavel'): ?>
        <div class="alert alert-danger">
            ❌ O cupom inserido não é aplicável. Verifique o valor mínimo ou a validade.
        </div>
    <?php endif; ?>

    <?php if (empty($itens)): ?>
        <p class="text-muted">Seu carrinho está vazio.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                    <th>Remover</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['produto']->nome) ?></td>
                        <td><?= htmlspecialchars($item['variacao']->nome) ?></td>
                        <td><?= $item['quantidade'] ?></td>
                        <td>R$ <?= number_format($item['produto']->preco, 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                        <td>
                            <form action="/?rota=carrinho/remover" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este item?');">
                                <input type="hidden" name="variacao_id" value="<?= $item['variacao']->id ?>">
                                <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php
                    $desconto = $_SESSION['cupom']['desconto'] ?? 0;
                    $totalComDesconto = $total - $desconto;
                ?>
                <tr>
                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                    <td>
                        <?php if ($desconto > 0): ?>
                            <span class="text-decoration-line-through text-muted">R$ <?= number_format($total, 2, ',', '.') ?></span><br>
                            <strong>R$ <?= number_format($totalComDesconto, 2, ',', '.') ?></strong>
                        <?php else: ?>
                            <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php if ($desconto > 0): ?>
                    <tr>
                        <td colspan="4" class="text-end text-success"><strong>Desconto:</strong></td>
                        <td class="text-success">- R$ <?= number_format($desconto, 2, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>
            </tfoot>
        </table>

        <!-- Formulário para aplicar o CEP -->
        <form action="/?rota=carrinho/calcularFrete" method="POST" class="row g-2 mb-3 d-flex justify-content-end">
            <div class="col-auto">
                <label for="cep" class="visually-hidden">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control"
                       placeholder="Digite seu CEP" value="<?= $_SESSION['cep'] ?? '' ?>" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </form>

        <!-- Formulário para aplicar o cupom -->
        <form action="/?rota=carrinho/aplicarCupom" method="POST" class="row g-2 mb-3">
            <div class="col-md-4">
                <label for="cupom" class="form-label">Cupom de Desconto</label>
                <input type="text" name="cupom" id="cupom" class="form-control" placeholder="Digite um cupom válido">
            </div>
            <div class="col-auto d-flex align-items-end">
                <button type="submit" class="btn btn-secondary">Aplicar Cupom</button>
            </div>
        </form>
        <?php if (isset($_SESSION['cupom'])): ?>
            <div class="alert alert-success">
                Cupom aplicado: <strong><?= $_SESSION['cupom']['codigo'] ?></strong> - 
                Desconto: <strong>R$ <?= number_format($_SESSION['cupom']['desconto'], 2, ',', '.') ?></strong>
            </div>
        <?php endif; ?>

        <!-- Formulário para finalizar pedido -->
        <form action="/?rota=pedido/finalizar" method="POST" class="mt-4">
            <input type="hidden" name="cep" value="<?= $_SESSION['cep'] ?? '' ?>">
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço de Entrega</label>
                <input type="text" name="endereco" id="endereco" class="form-control"
                       placeholder="Rua, número, complemento, bairro, cidade"
                       value="<?= ($_SESSION['frete_info']['logradouro'] ?? '') . ' ' . ($_SESSION['frete_info']['bairro'] ?? '') ?>"
                       required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu email" required>
            </div>
          
                <?php if (isset($_SESSION['frete'])): ?>
                    <div class="alert alert-info">
                        Frete calculado: <strong>R$ <?= number_format($_SESSION['frete'], 2, ',', '.') ?></strong>
                    </div>
                <?php endif; ?>
            <button type="submit" class="btn btn-success">Finalizar Pedido</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
