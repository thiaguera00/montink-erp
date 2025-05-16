<?php

class Pedido {
    public int $id;
    public float $total;
    public float $frete;
    public float $desconto;
    public string $cepEntrega;
    public string $enderecoEntrega;
    public string $status;
    public DateTime $criadoEm;

    public function __construct(
        float $total,
        float $frete,
        float $desconto,
        string $cepEntrega,
        string $enderecoEntrega,
        string $status = 'pendente',
        ?DateTime $criadoEm = null,
        ?int $id = null
    ) {
        $this->total = $total;
        $this->frete = $frete;
        $this->desconto = $desconto;
        $this->cepEntrega = $cepEntrega;
        $this->enderecoEntrega = $enderecoEntrega;
        $this->status = $status;
        $this->criadoEm = $criadoEm ?? new DateTime();
        $this->id = $id ?? 0;
    }
}
