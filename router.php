<?php

session_start();

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
require_once __DIR__ . '/controllers/CepController.php';
require_once __DIR__ . '/repository/PedidoRepository.php';
require_once __DIR__ . '/controllers/PedidoController.php';

$produtoRepo = new ProdutoRepository($db);
$variacaoRepo = new VariacaoRepository($db);
$estoqueRepo = new EstoqueRepository($db);
$pedidoRepo = new PedidoRepository($db);

$produtoController = new ProdutoController($produtoRepo, $variacaoRepo, $estoqueRepo);
$variacaoController = new VariacaoController($db);
$pedidoController = new PedidoController($pedidoRepo, $variacaoRepo, $produtoRepo);

switch ($rota) {

    // Produtos
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

    // Variações
    case 'variacao/form':
        $variacaoController->form();
    break;

    case 'variacao/salvar':
        $variacaoController->salvarViaPost($_POST);
        header("Location: /?rota=produto/listar&sucesso=4");
        exit;

    // Carrinho
    case 'carrinho/adicionar':
        $variacaoId = (int)($_POST['variacao_id'] ?? 0);

        if ($variacaoId) {
            if (!isset($_SESSION['carrinho'][$variacaoId])) {
                $_SESSION['carrinho'][$variacaoId] = 1;
            } else {
                $_SESSION['carrinho'][$variacaoId]++;
            }
            header("Location: /?rota=produto/listar&sucesso=6");
        } else {
            header("Location: /?rota=produto/listar&erro=1");
        }
        exit;

    case 'carrinho/ver':
        $itens = [];
        $total = 0;
        $frete = $_SESSION['frete'] ?? 0;

        if (!empty($_SESSION['carrinho'])) {
            foreach ($_SESSION['carrinho'] as $variacaoId => $qtd) {
                $variacao = $variacaoRepo->buscarPorId($variacaoId);
                if (!$variacao) continue;

                $produto = $produtoRepo->buscarPorId($variacao->produtoId);
                if (!$produto) continue;

                $subtotal = $qtd * $produto->preco;
                $itens[] = [
                    'produto' => $produto,
                    'variacao' => $variacao,
                    'quantidade' => $qtd,
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
            }

            if ($total > 200) {
                $frete = 0;
            } elseif ($total >= 52 && $total <= 166.59) {
                $frete = 15;
            } else {
                $frete = 20;
            }

            $_SESSION['frete'] = $frete;
            $total_com_frete = $total + $frete;
        }

        require __DIR__ . '/views/carrinho/carrinhoVer.php';
    break;

    case 'carrinho/calcularFrete':
        $controller = new CepController();
        $controller->consultarViaPost($_POST);
    break;
    
    //Pedido
    case 'pedido/finalizar':
        $pedidoController->finalizar();
    break;

    case 'pedido/confirmado':
        $pedidoController->confirmado();
    break;

    default:
        http_response_code(404);
        echo "<h2 style='padding: 2rem'>404 - Rota não encontrada</h2>";
}
