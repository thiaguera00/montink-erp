<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php'; 

class EmailService {
    public static function enviarPedido(
        string $paraEmail,
        string $paraNome,
        string $enderecoEntrega,
        float $total,
        float $frete,
        float $desconto,
        array $itens
    ): bool {
        $mail = new PHPMailer(true);

        try {
            
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; 
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('thiagocaetano155@gmail.com', 'Sistema de Pedidos');
            $mail->addAddress($paraEmail, $paraNome);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmação de Pedido';

            $body = "<h3>Seu pedido foi finalizado com sucesso!</h3>";
            $body .= "<p><strong>Endereço de entrega:</strong> {$enderecoEntrega}</p><ul>";

            foreach ($itens as $item) {
                $body .= "<li>{$item['produto']} - {$item['variacao']} - Quantidade: {$item['quantidade']}</li>";
            }

            $body .= "</ul>";
            $body .= "<p><strong>Total:</strong> R$ " . number_format($total, 2, ',', '.') . "</p>";
            $body .= "<p><strong>Desconto:</strong> R$ " . number_format($desconto, 2, ',', '.') . "</p>";
            $body .= "<p><strong>Frete:</strong> R$ " . number_format($frete, 2, ',', '.') . "</p>";

            $mail->Body = $body;

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Erro ao enviar email: {$mail->ErrorInfo}");
            return false;
        }
    }
}
