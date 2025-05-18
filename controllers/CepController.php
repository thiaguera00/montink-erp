<?php

class CepController {
    public function consultarViaPost(array $data): void {
        $cep = preg_replace('/[^0-9]/', '', $data['cep']);

        if (strlen($cep) !== 8) {
            header("Location: /?rota=carrinho/ver&erro=cep_invalido");
            exit;
        }

        $url = "https://viacep.com.br/ws/{$cep}/json/";
        $resposta = @file_get_contents($url);

        if ($resposta === false) {
            header("Location: /?rota=carrinho/ver&erro=cep_nao_encontrado");
            exit;
        }

        $dados = json_decode($resposta, true);

        if (isset($dados['erro'])) {
            header("Location: /?rota=carrinho/ver&erro=cep_nao_encontrado");
            exit;
        }

        session_start();

        $_SESSION['cep'] = $cep;
        $_SESSION['frete_info'] = [
            'logradouro' => $dados['logradouro'],
            'bairro' => $dados['bairro'],
            'cidade' => $dados['localidade'],
            'uf' => $dados['uf']
        ];

        header("Location: /?rota=carrinho/ver");
        exit;
    }
}
