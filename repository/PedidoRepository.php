<?php

require_once __DIR__ .  '/../models/Pedido.php';

class PedidoRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function salvar(Pedido $pedido): bool {
        $stmt = $this->db->prepare("
            INSERT INTO pedidos (total, frete, desconto, cep_entrega, endereco_entrega, status, criado_em)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $success = $stmt->execute([
            $pedido->total,
            $pedido->frete,
            $pedido->desconto,
            $pedido->cepEntrega,
            $pedido->enderecoEntrega,
            $pedido->status,
            $pedido->criadoEm->format('Y-m-d H:i:s')
        ]);

        if ($success) {
            $pedido->id = $this->db->lastInsertId();
        }

        return $success;
    }

    public function buscarPorId(int $id): ?Pedido {
        $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            return new Pedido(
                $row['total'],
                $row['frete'],
                $row['desconto'],
                $row['cep_entrega'],
                $row['endereco_entrega'],
                $row['status'],
                new DateTime($row['criado_em']),
                $row['id']
            );
        }

        return null;
    }
    public function atualizarStatus(int $pedidoId, string $novoStatus): bool {
        $stmt = $this->db->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        return $stmt->execute([$novoStatus, $pedidoId]);
    }

    public function deletar(int $pedidoId): bool {
        $stmt = $this->db->prepare("DELETE FROM pedidos WHERE id = ?");
        return $stmt->execute([$pedidoId]);
    }
}
