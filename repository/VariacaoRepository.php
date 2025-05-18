<?php

require_once __DIR__ .  '/../models/Variacao.php';

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
        $stmt = $this->db->prepare("
            SELECT v.id, v.produto_id, v.nome, e.quantidade
            FROM variacoes v
            LEFT JOIN estoque e ON e.variacao_id = v.id
            WHERE v.produto_id = ?
        ");
        $stmt->execute([$produtoId]);

        $variacoes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $v = new Variacao(
                $row['produto_id'],
                $row['nome'],
                (int)$row['id']
            );

            $v->quantidade = (int)($row['quantidade'] ?? 0);

            $variacoes[] = $v;
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

    public function atualizar(Variacao $variacao): bool {
        $stmt = $this->db->prepare("UPDATE variacoes SET nome = ? WHERE id = ?");
        return $stmt->execute([
            $variacao->nome,
            $variacao->id
        ]);
    }
}
