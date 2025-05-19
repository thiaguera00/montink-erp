<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Cupom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
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
</body>
</html>
