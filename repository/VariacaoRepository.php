<?php

require_once '../models/Variacao.php';

class VariacaoRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function salvar(Variacao $variacao): bool {
        $stmt = $this->db->prepare("INSERT INTO variacoes (produto_id, nome) VALUES (?, ?)");
        $success = $stmt->execute([
            $variacao->produtoId,
            $variacao->nome
        ]);

        if ($success) {
            $variacao->id = $this->db->lastInsertId();
        }

        return $success;
    }

    public function listarPorProduto(int $produtoId): array {
        $stmt = $this->db->prepare("SELECT * FROM variacoes WHERE produto_id = ?");
        $stmt->execute([$produtoId]);

        $variacoes = [];
        while ($row = $stmt->fetch()) {
            $variacoes[] = new Variacao(
                $row['produto_id'],
                $row['nome'],
                $row['id']
            );
        }

        return $variacoes;
    }

    public function deletarPorProduto(int $produtoId): bool {
        $stmt = $this->db->prepare("DELETE FROM variacoes WHERE produto_id = ?");
        return $stmt->execute([$produtoId]);
    }

    public function buscarPorId(int $id): ?Variacao {
        $stmt = $this->db->prepare("SELECT * FROM variacoes WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            return new Variacao($row['produto_id'], $row['nome'], $row['id']);
        }

        return null;
    }
}
