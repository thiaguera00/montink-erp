<?php

require_once __DIR__ . '/../repository/PedidoRepository.php';
require_once __DIR__ . '/../repository/VariacaoRepository.php';
require_once __DIR__ . '/../repository/ProdutoRepository.php';
require_once __DIR__ . '/../models/Pedido.php';

class PedidoController {
      private PedidoRepository $repo;
    private VariacaoRepository $variacaoRepo;
    private ProdutoRepository $produtoRepo;

    public function __construct(
        PedidoRepository $repo,
        VariacaoRepository $variacaoRepo,
        ProdutoRepository $produtoRepo
    ) {
        $this->repo = $repo;
        $this->variacaoRepo = $variacaoRepo;
        $this->produtoRepo = $produtoRepo;
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
            if (!$variacao) continue;

            $produto = $this->produtoRepo->buscarPorId($variacao->produtoId);
            if (!$produto) continue;

            $subtotal = $produto->preco * $qtd;
            $total += $subtotal;
        }

        if ($total > 200) {
            $frete = 0;
        } elseif ($total >= 52 && $total <= 166.59) {
            $frete = 15;
        } else {
            $frete = 20;
        }

        $cep = $_SESSION['cep'] ?? ($_POST['cep'] ?? '');
        $endereco = $_POST['endereco'] ?? ($_SESSION['frete_info']['logradouro'] ?? 'Endereço não informado');

        $pedido = new Pedido(
            $total,
            $frete,
            0,
            $cep,
            $endereco
        );

        if ($this->repo->salvar($pedido)) {
            unset($_SESSION['carrinho'], $_SESSION['frete'], $_SESSION['cep'], $_SESSION['frete_info']);

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

