<?php 

require_once 'utils/database.php';
require_once 'models/Produto.php';
require_once 'repository/ProdutoRepository.php';

$produtoRepo = new ProdutoRepository($db);

$produto = $produtoRepo->buscarPorId(1);

if ($produto) {
    echo $produto->nome . PHP_EOL;
    echo $produto->preco . PHP_EOL;
    echo $produto->id . PHP_EOL;
} else {
    echo "Produto não encontrado.";
}

