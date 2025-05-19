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
}
