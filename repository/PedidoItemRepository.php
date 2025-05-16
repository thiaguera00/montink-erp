<?php

require_once 'models/PedidoItem.php';

class PedidoItemRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function salvar(PedidoItem $item): bool {
        $stmt = $this->db->prepare("
            INSERT INTO pedido_itens (pedido_id, variacao_id, quantidade, preco_unitario)
            VALUES (?, ?, ?, ?)
        ");

        $success = $stmt->execute([
            $item->pedidoId,
            $item->variacaoId,
            $item->quantidade,
            $item->precoUnitario
        ]);

        if ($success) {
            $item->id = $this->db->lastInsertId();
        }

        return $success;
    }

    public function listarPorPedido(int $pedidoId): array {
        $stmt = $this->db->prepare("SELECT * FROM pedido_itens WHERE pedido_id = ?");
        $stmt->execute([$pedidoId]);

        $itens = [];
        while ($row = $stmt->fetch()) {
            $itens[] = new PedidoItem(
                $row['pedido_id'],
                $row['variacao_id'],
                $row['quantidade'],
                $row['preco_unitario'],
                $row['id']
            );
        }

        return $itens;
    }
}
