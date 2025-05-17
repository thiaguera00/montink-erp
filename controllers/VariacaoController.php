<?php

require_once __DIR__ . '/../models/Variacao.php';
require_once __DIR__ . '/../repository/VariacaoRepository.php';
require_once __DIR__ . '/../repository/ProdutoRepository.php';
require_once __DIR__ . '/../repository/EstoqueRepository.php';

class VariacaoController {
    private PDO $db;
    private VariacaoRepository $variacaoRepo;
    private ProdutoRepository $produtoRepo;
    private EstoqueRepository $estoqueRepo;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->variacaoRepo = new VariacaoRepository($db);
        $this->produtoRepo = new ProdutoRepository($db);
        $this->estoqueRepo = new EstoqueRepository($db);
    }

    public function form(): void {
        $produtos = $this->produtoRepo->listar();
        require __DIR__ . '/../views/variacoes/variacaoForm.php';
    }

    public function salvarViaPost(array $data): void {
        try {
            $variacao = new Variacao(
                (int)$data['produto_id'],
                $data['nome']
            );
            
            $this->variacaoRepo->salvar($variacao);

            $estoque = new Estoque($variacao->id, (int)$data['quantidade']);
            $this->estoqueRepo->salvar($estoque);

        } catch (Exception $e) {
            die('Erro ao salvar variação e estoque: ' . $e->getMessage());
        }

    }
}
