<?php

require_once __DIR__ . '/../repository/ProdutoRepository.php';
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController {
    private ProdutoRepository $repository;

    public function __construct(ProdutoRepository $repository) {
        $this->repository = $repository;
    }

    public function salvarViaPost(array $dados): bool {
        $produto = new Produto($dados['nome'], (float)$dados['preco']);
        return $this->repository->salvar($produto);
    }

    public function listar(): void {
        $produtos = $this->repository->listar();
        require __DIR__ . '/../views/produtos/produtoListar.php';
    }

    public function buscarParaEdicao(int $id): void {
        $produto = $this->repository->buscarPorId($id);
        require __DIR__ . '/../views/produtos/produtoEditar.php';
    }

    public function atualizarViaPost(array $dados): bool {
        $produto = new Produto(
            $dados['nome'],
            (float)$dados['preco'],
            new DateTime(),
            (int)$dados['id']
        );
        return $this->repository->atualizar($produto);
    }

    public function excluir(int $id): bool {
        return $this->repository->deletar($id);
    }
}
