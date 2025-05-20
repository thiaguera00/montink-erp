<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .variacao-group {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 8px;
        }
    </style>
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
    <h2>Cadastrar Produto</h2>
    <form action="/?rota=produto/salvar" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Produto</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="preco" class="form-label">Preço (R$)</label>
            <input type="number" step="0.01" name="preco" class="form-control" required>
        </div>

        <div>
            <button type="submit" class="btn btn-success">Salvar Produto</button>
        </div>
    </form>
</div>

    <script>
        let index = 1;
        document.getElementById('add-variacao').addEventListener('click', () => {
            const container = document.getElementById('variacoes-container');

            const grupo = document.createElement('div');
            grupo.className = 'variacao-group';

            grupo.innerHTML = `
                <div class="mb-2">
                    <label>Nome da Variação</label>
                    <input type="text" name="variacoes[${index}][nome]" class="form-control" required>
                </div>
                <div>
                    <label>Estoque</label>
                    <input type="number" name="variacoes[${index}][quantidade]" class="form-control" required>
                </div>
            `;

            container.appendChild(grupo);
            index++;
        });
    </script>
</body>
</html>
