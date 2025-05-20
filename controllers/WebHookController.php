<?php

require_once __DIR__ . '/../repository/PedidoRepository.php';

class WebhookController {
    private PedidoRepository $repo;

    public function __construct(PedidoRepository $repo) {
        $this->repo = $repo;
    }

    public function atualizarStatusViaWebhook(): void {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['pedido_id'], $input['status'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados inválidos']);
            return;
        }

        $pedidoId = (int)$input['pedido_id'];
        $status = strtolower(trim($input['status']));

        $pedido = $this->repo->buscarPorId($pedidoId);

        if(!$pedido) {
            http_response_code(404);
            echo json_encode(['erro' => 'Pedido nao encontrado']);
            return;
        }

        if ($status === 'cancelado') {
            $this->repo->deletar($pedidoId);
            echo json_encode(['mensagem' => 'Pedido cancelado e removido com sucesso.']);
        } else {
            $this->repo->atualizarStatus($pedidoId, $status);
            echo json_encode(['mensagem' => "Status do pedido atualizado para '{$status}'"]);
        }
    }
}
