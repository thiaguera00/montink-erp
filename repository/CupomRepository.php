<?php

require_once __DIR__ . '/../models/Cupom.php';

class CupomRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function buscarPorCodigo(string $codigo): ?Cupom {
        $stmt = $this->db->prepare("SELECT * FROM cupons WHERE codigo = ?");
        $stmt->execute([$codigo]);
        $row = $stmt->fetch();

        if ($row) {
            return new Cupom(
                $row['codigo'],
                (float) $row['desconto_percentual'],
                (float) $row['valor_minimo'],
                new DateTime($row['validade']),
                (int) $row['id']
            );
        }

        return null;
    }

    public function salvar(Cupom $cupom): bool {
        $stmt = $this->db->prepare("
            INSERT INTO cupons (codigo, desconto_percentual, valor_minimo, validade)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $cupom->codigo,
            $cupom->descontoPercentual,
            $cupom->valorMinimo,
            $cupom->validade->format('Y-m-d')
        ]);
    }

    public function buscarTodos(): array {
        $stmt = $this->db->query("SELECT * FROM cupons ORDER BY criado_em DESC");
        $rows = $stmt->fetchAll();

        $cupons = [];

        foreach ($rows as $row) {
            $cupons[] = new Cupom(
                $row['codigo'],
                (float) $row['desconto_percentual'],
                (float) $row['valor_minimo'],
                new DateTime($row['validade']),
                (int) $row['id'],
                isset($row['criado_em']) ? new DateTime($row['criado_em']) : null
            );
        }

        return $cupons;
    }

}
