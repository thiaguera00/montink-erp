<?php
require_once '../models/Estoque.php';

class EstoqueRepository {
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function salvar(Estoque $estoque): bool {
        $stmt = $this->db->prepare("INSERT INTO estoque (variacao_id, quantidade ) VALUES (?, ?)");
        $success = $stmt->execute([
            $estoque->variacaoId,
            $estoque->quantidade
        ]);

        if ($success) {
            $estoque->id = $this->db->lastInsertId();
        }

        return $success;
    }

    public function atualizarQuantidade(int $variacaoId, int $novaQuantidade): bool {
        $stmt = $this->db->prepare("UPDATE estoque SET quantidade = ? WHERE variacao_id = ?");
        return $stmt->execute([$novaQuantidade, $variacaoId]);
    }

    public function buscarPorVariacao(int $variacaoId): ?Estoque {
        $stmt = $this->db->prepare("SELECT * FROM estoque WHERE variacao_id = ?");
        $stmt->execute([$variacaoId]);
        $row = $stmt->fetch();

        if ($row) {
            return new Estoque($row['variacao_id'], $row['quantidade'], $row['id']);
        }

        return null;

    }

    public function decrementarEstoque(int $variacaoId, int $quantidade): bool {
        $stmt = $this->db->prepare("UPDATE estoque SET quantidade = quantidade - ? WHERE variacao_id = ?");
        return $stmt->execute([$quantidade, $variacaoId]);
    }
}