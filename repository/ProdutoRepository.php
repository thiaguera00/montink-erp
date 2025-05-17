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

    public function listarComVariações(): array {
        $sql = "
            SELECT 
                p.id AS produto_id,
                p.nome AS produto_nome,
                p.preco,
                v.id AS variacao_id,
                v.nome AS variacao_nome,
                e.quantidade
            FROM produtos p
            LEFT JOIN variacoes v ON v.produto_id = p.id
            LEFT JOIN estoque e on e.variacao_id = v.id
            ORDER BY p.id DESC
        ";

        $stmt = $this->db->query($sql);
        $resultados = $stmt->fetchAll();

        $produtos = [];

        foreach ($resultados as $row) {
            $pid = $row['produto_id'];

            if (!isset($produtos[$pid])) {
                $produtos[$pid] = [
                    'id' => $pid,
                    'nome' => $row['produto_nome'],
                    'preco' => $row['preco'],
                    'variacoes' => []
                ];
            }

           if ($row['variacao_id']) {
                $produtos[$pid]['variacoes'][] = [
                    'id' => $row['variacao_id'],
                    'nome' => $row['variacao_nome'],
                    'quantidade' => $row['quantidade'] ?? 0
                ];
            }
        }

        return array_values($produtos);
    }

}
