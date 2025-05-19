<?php

require_once __DIR__ . '/../repository/PedidoRepository.php';
require_once __DIR__ . '/../repository/VariacaoRepository.php';
require_once __DIR__ . '/../repository/ProdutoRepository.php';
require_once __DIR__ . '/../repository/CupomRepository.php';
require_once __DIR__ . '/../models/Pedido.php';

class PedidoController {
    private PedidoRepository $repo;
    private VariacaoRepository $variacaoRepo;
    private ProdutoRepository $produtoRepo;
    private CupomRepository $cupomRepo;

    public function __construct(
        PedidoRepository $repo,
        VariacaoRepository $variacaoRepo,
        ProdutoRepository $produtoRepo,
        CupomRepository $cupomRepo
    ) {
        $this->repo = $repo;
        $this->variacaoRepo = $variacaoRepo;
        $this->produtoRepo = $produtoRepo;
        $this->cupomRepo = $cupomRepo;
    }

    public function finalizar(): void {
    session_start();

    if (empty($_SESSION['carrinho'])) {
        echo "Carrinho vazio.";
        return;
    }

    $total = 0;

    foreach ($_SESSION['carrinho'] as $variacaoId => $qtd) {
        $variacao = $this->variacaoRepo->buscarPorId($variacaoId);
        $produto = $this->produtoRepo->buscarPorId($variacao->produtoId);
        $total += $produto->preco * $qtd;
    }

    // Calcula frete
    if ($total > 200) {
        $frete = 0;
    } elseif ($total >= 52 && $total <= 166.59) {
        $frete = 15;
    } else {
        $frete = 20;
    }

    // Pega o desconto da sessão
    $desconto = $_SESSION['cupom']['desconto'] ?? 0;

    $cep = $_SESSION['cep'] ?? ($_POST['cep'] ?? '');
    $endereco = $_POST['endereco'] ?? ($_SESSION['frete_info']['logradouro'] ?? 'Endereço não informado');

    $pedido = new Pedido(
        $total,
        $frete,
        $desconto,
        $cep,
        $endereco
    );

    if ($this->repo->salvar($pedido)) {
        unset($_SESSION['carrinho'], $_SESSION['frete'], $_SESSION['cep'], $_SESSION['frete_info'], $_SESSION['cupom']);
        header("Location: /?rota=pedido/confirmado");
        exit;
    } else {
        echo "Erro ao salvar pedido.";
    }
}




    public function confirmado(): void {
        echo "<h2>✅ Pedido finalizado com sucesso!</h2>";
        echo '<a href="/?rota=produto/listar">Voltar para produtos</a>';
    }
}

