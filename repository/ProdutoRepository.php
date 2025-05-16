<?php

require_once __DIR__ . '/../models/Produto.php';

class ProdutoRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function salvar(Produto $produto): bool {
        $stmt = $this->db->prepare("INSERT INTO produtos (nome, preco, criado_em) VALUES (?, ?, ?)");
        return $stmt->execute([
            $produto->nome,
            $produto->preco,
            $produto->criadoEm->format('Y-m-d H:i:s')
        ]);
    }

    public function listar(): array {
        $stmt = $this->db->query("SELECT * FROM produtos ORDER BY criado_em DESC");
        $resultados = [];

        while ($row = $stmt->fetch()) {
            $resultados[] = new Produto(
                $row['nome'],
                $row['preco'],
                new DateTime($row['criado_em']),
                $row['id']
            );
        }

        return $resultados;
    }

    public function buscarPorId(int $id): ?Produto {
        $stmt = $this->db->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            return new Produto(
                $row['nome'],
                $row['preco'],
                new DateTime($row['criado_em']),
                $row['id']
            );
        }

        return null;
    }

    public function atualizar(Produto $produto): bool {
        $stmt = $this->db->prepare("UPDATE produtos SET nome = ?, preco = ? WHERE id = ?");
        return $stmt->execute([
            $produto->nome,
            $produto->preco,
            $produto->id
        ]);
    }

    public function deletar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
