<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cupons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Cupons Cadastrados</h2>
    <a href="/?rota=cupom/form" class="btn btn-primary mb-3">+ Novo Cupom</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Desconto (%)</th>
                <th>Valor Mínimo</th>
                <th>Validade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cupons as $cupom): ?>
                <tr>
                    <td><?= htmlspecialchars($cupom->codigo) ?></td>
                    <td><?= $cupom->descontoPercentual ?></td>
                    <td>R$ <?= number_format($cupom->valorMinimo, 2, ',', '.') ?></td>
                    <td><?= $cupom->validade->format('d/m/Y') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
