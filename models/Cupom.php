<?php

class Cupom {
    public int $id;
    public string $codigo;
    public float $descontoPercentual;
    public float $valorMinimo;
    public DateTime $validade;

    public function __construct(
        string $codigo,
        float $descontoPercentual,
        float $valorMinimo,
        DateTime $validade,
        ?int $id = null
    ) {
        $this->codigo = $codigo;
        $this->descontoPercentual = $descontoPercentual;
        $this->valorMinimo = $valorMinimo;
        $this->validade = $validade;
        $this->id = $id ?? 0;
    }
}

