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
<body class="container py-4">
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

        <hr>
        

        <div>
            <button type="submit" class="btn btn-success">Salvar Produto</button>
        </div>
    </form>

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
