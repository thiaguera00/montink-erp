<?php

require_once __DIR__ . '/../utils/EmailService.php';
require_once __DIR__ . '/../repository/PedidoRepository.php';
require_once __DIR__ . '/../repository/VariacaoRepository.php';
require_once __DIR__ . '/../repository/ProdutoRepository.php';
require_once __DIR__ . '/../repository/CupomRepository.php';
require_once __DIR__ . '/../repository/PedidoItemRepository.php';
require_once __DIR__ . '/../repository/EstoqueRepository.php';
require_once __DIR__ . '/../models/Pedido.php';

class PedidoController {
    private PedidoRepository $repo;
    private VariacaoRepository $variacaoRepo;
    private ProdutoRepository $produtoRepo;
    private CupomRepository $cupomRepo;
    private PedidoItemRepository $pedidoItemRepo;
    private EstoqueRepository $estoqueRepo;

    public function __construct(
        PedidoRepository $repo,
        VariacaoRepository $variacaoRepo,
        ProdutoRepository $produtoRepo,
        CupomRepository $cupomRepo,
        PedidoItemRepository $pedidoItemRepo,
        EstoqueRepository $estoqueRepo
    ) {
        $this->repo = $repo;
        $this->variacaoRepo = $variacaoRepo;
        $this->produtoRepo = $produtoRepo;
        $this->cupomRepo = $cupomRepo;
        $this->pedidoItemRepo = $pedidoItemRepo;
        $this->estoqueRepo = $estoqueRepo;
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

        if ($total > 200) {
            $frete = 0;
        } elseif ($total >= 52 && $total <= 166.59) {
            $frete = 15;
        } else {
            $frete = 20;
        }

        $desconto = $_SESSION['cupom']['desconto'] ?? 0;
        $email = $_POST['email'];
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
            $itensEmail = [];
            foreach ($_SESSION['carrinho'] as $variacaoId => $qtd) {
                $variacao = $this->variacaoRepo->buscarPorId($variacaoId);
                $produto = $this->produtoRepo->buscarPorId($variacao->produtoId);

                $item = new PedidoItem(
                    $pedido->id,
                    $variacao->id,
                    $qtd,
                    $produto->preco
                );

                $this->pedidoItemRepo->salvar($item);
                $this->estoqueRepo->decrementarEstoque($variacaoId, $qtd);

                $itensEmail[] = [
                    'produto' => $produto->nome,
                    'variacao' => $variacao->nome,
                    'quantidade' => $qtd
                ];
            }

            
            EmailService::enviarPedido(
                $email,          
                'Cliente Montink',  
                $endereco,               
                $total,                  
                $frete,                   
                $desconto,                
                $itensEmail 
            );

            unset($_SESSION['carrinho'], $_SESSION['frete'], $_SESSION['cep'], $_SESSION['frete_info'], $_SESSION['cupom']);
            header("Location: /?rota=pedido/confirmado");
            exit;
        }
    }

    public function confirmado(): void {
        echo "<h2>✅ Pedido finalizado com sucesso!</h2>";
        echo '<a href="/?rota=produto/listar">Voltar para produtos</a>';
    }
}

