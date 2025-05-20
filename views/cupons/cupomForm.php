<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Cupom</title>
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
    <h2>Cadastrar Novo Cupom</h2>
    <form action="/?rota=cupom/salvar" method="POST">
        <div class="mb-3">
            <label class="form-label">Código do Cupom</label>
            <input type="text" name="codigo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Desconto (%)</label>
            <input type="number" name="desconto_percentual" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Valor Mínimo</label>
            <input type="number" name="valor_minimo" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Validade</label>
            <input type="date" name="validade" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar Cupom</button>
        <a href="/?rota=cupom/listar" class="btn btn-secondary">Ver Cupons</a>
    </form>
</div>
</body>
</html>
