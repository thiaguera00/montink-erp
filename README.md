# 🛒 ERP Montink

Este projeto é uma aplicação PHP que simula um sistema de vendas com cadastro de produtos, variações, controle de estoque, aplicação de cupons de desconto, cálculo de frete, carrinho de compras com sessão e envio de e-mail ao finalizar pedido.

---

## 📌 Funcionalidades

- Cadastro de produtos e variações
- Controle de estoque por variação
- Carrinho de compras com controle via `$_SESSION`
- Aplicação de cupons de desconto com validade e valor mínimo
- Cálculo de frete por faixa de valor
- Finalização de pedido com armazenamento em banco
- Envio de e-mail simulando confirmação de pedido
- Webhook para alteração de status do pedido (cancelamento, confirmação, etc.)

---

## 🛠️ Tecnologias

- PHP (sem frameworks)
- MySQL (Docker)
- HTML + Bootstrap 5 (frontend simples)
- PHPMailer (para envio de e-mail utilizando o mailtrap)

---

## ⚙ CONFIGURAR O PROJETO
- Estou usando docker para rodar o banco de dados caso já tenha o MYSQL instalado não é necessário rodar o docker

- Existe um arquivo SQL com as tabelas em database/sql/init.sql

- Estou usando o mailtrap para testar o envio de email então é necessário criar uma conta e pegar as credencias 

- Após essas configurações configure seu .env usando o .env.example
--- 
### Digite o comando para baixar as depedências do projeto:
```bash
composer install
```
- Após instalar rode esse comando:

```bash
php -S localhost:8000
```

## 🚀 PONTOS FUTUROS

- Deixar o visual mais agradavel
- Ajustar a nomenclatura de rotas
