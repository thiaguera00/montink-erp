<?php

class Estoque {
    public int $id;
    public int $variacaoId;
    public int $quantidade;

    public function __construct(int $variacaoId, int $quantidade, ?int $id = null) {
        $this->variacaoId = $variacaoId;
        $this->quantidade = $quantidade;
        $this->id = $id ?? 0;
    }
}