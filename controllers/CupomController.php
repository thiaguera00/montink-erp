<?php 
require_once __DIR__ . '/../repository/CupomRepository.php';
require_once __DIR__ . '/../repository/VariacaoRepository.php';
require_once __DIR__ . '/../repository/ProdutoRepository.php';

class CupomController {
    private CupomRepository $cupomRepo;
    private VariacaoRepository $variacaoRepo;
    private ProdutoRepository $produtoRepo;

    public function __construct(
        CupomRepository $cupomRepo,
        VariacaoRepository $variacaoRepo,
        ProdutoRepository $produtoRepo
    ) {
        $this->cupomRepo = $cupomRepo;
        $this->variacaoRepo = $variacaoRepo;
        $this->produtoRepo = $produtoRepo;
    }

    public function aplicarCupom(string $codigo): void {
        session_start();

        $cupom = $this->cupomRepo->buscarPorCodigo($codigo);

        if (!$cupom) {
            unset($_SESSION['cupom']);
            header("Location: /?rota=carrinho/ver&erro=cupom_invalido");
            exit;
        }

        // Recalcular o total do carrinho
        $total = 0;
        foreach ($_SESSION['carrinho'] as $variacaoId => $qtd) {
            $variacao = $this->variacaoRepo->buscarPorId($variacaoId);
            $produto = $this->produtoRepo->buscarPorId($variacao->produtoId);
            $total += $produto->preco * $qtd;
        }

        $hoje = new DateTime();
        if ($cupom->validade >= $hoje && $total >= $cupom->valorMinimo) {
            $_SESSION['cupom'] = [
                'codigo' => $cupom->codigo,
                'desconto' => ($cupom->descontoPercentual / 100) * $total,
                'percentual' => $cupom->descontoPercentual
            ];
            header("Location: /?rota=carrinho/ver&sucesso=cupom_aplicado");
            exit;
        } else {
            unset($_SESSION['cupom']);
            header("Location: /?rota=carrinho/ver&erro=cupom_nao_aplicavel");
            exit;
        }
    }
}
