<?php

$rota = $_GET['rota'] ?? '';

require_once __DIR__ . '/utils/database.php';
require_once __DIR__ . '/models/Produto.php';
require_once __DIR__ . '/repository/ProdutoRepository.php';
require_once __DIR__ . '/controllers/ProdutoController.php';

$controller = new ProdutoController(new ProdutoRepository($db));

switch ($rota) {
    case 'produto/salvar':
        $controller->salvarViaPost($_POST);
        header("Location: /?rota=produto/listar&sucesso=1");
        exit;

    case 'produto/listar':
        $controller->listar();
        break;

    case 'produto/editar':
        $controller->buscarParaEdicao((int)$_GET['id']);
        break;

    case 'produto/atualizar':
        $controller->atualizarViaPost($_POST);
        header("Location: /?rota=produto/listar&sucesso=2");
        exit;

    case 'produto/excluir':
        $controller->excluir((int)$_GET['id']);
        header("Location: /?rota=produto/listar&sucesso=3");
        exit;

    case 'produto/form':
        require_once __DIR__ . '/views/produtos/produtoForm.php';
        break;

    default:
        echo "404 - Rota não encontrada";
}
