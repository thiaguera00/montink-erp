<?php

$rota = $_GET['rota'] ?? '';

require_once __DIR__ . '/utils/database.php';
require_once __DIR__ . '/models/Produto.php';
require_once __DIR__ . '/models/Variacao.php';
require_once __DIR__ . '/models/Estoque.php';
require_once __DIR__ . '/repository/ProdutoRepository.php';
require_once __DIR__ . '/repository/VariacaoRepository.php';
require_once __DIR__ . '/repository/EstoqueRepository.php';
require_once __DIR__ . '/controllers/ProdutoController.php';
require_once __DIR__ . '/controllers/VariacaoController.php';

$produtoRepo = new ProdutoRepository($db);
$variacaoRepo = new VariacaoRepository($db);
$estoqueRepo = new EstoqueRepository($db);
$produtoController = new ProdutoController($produtoRepo, $variacaoRepo, $estoqueRepo);
$variacaoController = new VariacaoController($db);

switch ($rota) {

    case 'produto/salvar':
        $produtoController->salvarViaPost($_POST);
        header("Location: /?rota=produto/listar&sucesso=1");
        exit;

    case 'produto/listar':
        $produtoController->listarComVariações();
        break;

    case 'produto/editar':
        $produtoController->buscarParaEdicao((int)$_GET['id']);
        break;

    case 'produto/atualizar':
        $produtoController->atualizarViaPost($_POST);
        header("Location: /?rota=produto/listar&sucesso=2");
        exit;

    case 'produto/excluir':
        $produtoController->excluir((int)$_GET['id']);
        header("Location: /?rota=produto/listar&sucesso=3");
        exit;

    case 'produto/form':
        require_once __DIR__ . '/views/produtos/produtoForm.php';
        break;

    case 'variacao/form':
        $variacaoController->form();
        break;

    case 'variacao/salvar':
        $variacaoController->salvarViaPost($_POST);
        header("Location: /?rota=produto/listar&sucesso=4");
        exit;

    default:
        http_response_code(404);
        echo "<h2 style='padding: 2rem'>404 - Rota não encontrada</h2>";
}
