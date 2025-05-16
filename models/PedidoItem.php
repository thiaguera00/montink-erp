<?php

class PedidoItem {
    public int $id;
    public int $pedidoId;
    public int $variacaoId;
    public int $quantidade;
    public float $precoUnitario;

    public function __construct(
        int $pedidoId,
        int $variacaoId,
        int $quantidade,
        float $precoUnitario,
        ?int $id = null
    ) {
        $this->pedidoId = $pedidoId;
        $this->variacaoId = $variacaoId;
        $this->quantidade = $quantidade;
        $this->precoUnitario = $precoUnitario;
        $this->id = $id ?? 0;
    }
}
