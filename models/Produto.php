<?php

class Produto {
    public int $id;
    public string $nome;
    public float $preco;
    public DateTime $criadoEm;

    public function __construct(string $nome, float $preco, ?DateTime $criadoEm = null, ?int $id = null) {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->criadoEm = $criadoEm ?? new DateTime();
        $this->id = $id ?? 0;
    }
}
