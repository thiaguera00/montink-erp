<?php

class Variacao {
    public int $id;
    public int $produtoId;
    public string $nome;

    public function __construct(int $produtoId, string $nome, ?int $id = null) {
        $this->produtoId = $produtoId;
        $this->nome = $nome;
        $this->id = $id ?? 0;
    }
}