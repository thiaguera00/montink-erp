<?php

require_once __DIR__ . '/../repository/ProdutoRepository.php';
require_once __DIR__ . '/../repository/VariacaoRepository.php';
require_once __DIR__ . '/../repository/EstoqueRepository.php';
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Variacao.php';
require_once __DIR__ . '/../models/Estoque.php';

class ProdutoController {
    private ProdutoRepository $produtoRepo;
    private VariacaoRepository $variacaoRepo;
    private EstoqueRepository $estoqueRepo;

    public function __construct(
        ProdutoRepository $produtoRepo,
        VariacaoRepository $variacaoRepo,
        EstoqueRepository $estoqueRepo
    ) {
        $this->produtoRepo = $produtoRepo;
        $this->variacaoRepo = $variacaoRepo;
        $this->estoqueRepo = $estoqueRepo;
    }

    public function listarComVariações(): void {
        $produtos = $this->produtoRepo->listarComVariações();
        require __DIR__ . '/../views/produtos/produtoListar.php';
    }

    public function salvarViaPost(array $dados): bool {
        $produto = new Produto($dados['nome'], (float)$dados['preco']);
        return $this->produtoRepo->salvar($produto);
    }

    public function buscarParaEdicao(int $id): void {
        $produto = $this->produtoRepo->buscarPorId($id);
        $variacoes = $this->variacaoRepo->listarPorProduto($id);

        foreach ($variacoes as &$v) {
            $estoque = $this->estoqueRepo->buscarPorVariacao($v->id);
            $v->quantidade = $estoque ? $estoque->quantidade : 0;
        }

        require __DIR__ . '/../views/produtos/produtoEditar.php';
    }

    public function atualizarViaPost(array $dados): bool {
        $produto = new Produto(
            $dados['nome'],
            (float)$dados['preco'],
            new DateTime(),
            (int)$dados['id']
        );
        $this->produtoRepo->atualizar($produto);

        if (isset($dados['variacoes']) && is_array($dados['variacoes'])) {
            foreach ($dados['variacoes'] as $id => $v) {
                $variacao = new Variacao($produto->id, $v['nome'], (int)$id);
                $this->variacaoRepo->atualizar($variacao);
                $this->estoqueRepo->atualizarQuantidade($variacao->id, (int)$v['quantidade']);
            }
        }

        if (!empty($dados['nova_variacao']['nome'])) {
            $nova = new Variacao($produto->id, $dados['nova_variacao']['nome']);
            $this->variacaoRepo->salvar($nova);
            $this->estoqueRepo->salvar(new Estoque($nova->id, (int)$dados['nova_variacao']['quantidade']));
        }

        return true;
    }

    public function excluir(int $id): bool {
        return $this->produtoRepo->deletar($id);
    }
}
