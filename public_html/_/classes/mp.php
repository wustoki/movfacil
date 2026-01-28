<?php

class MP
{

    private $mp_access_token;

    public function __construct() {
        include '../bd/config.php';
        $this->mp_access_token = MP_ACCESS_TOKEN;
    }

    public function verificarStatusPagamento($transacao_id)
    {
        $accessToken = $this->mp_access_token;
        $endpoint = "https://api.mercadopago.com/v1/payments/{$transacao_id}";

        // Configurações da requisição cURL
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Executa a requisição e captura a resposta
        $response = curl_exec($ch);
        $responseData = json_decode($response, true);
        curl_close($ch);

        if (isset($responseData['error'])) {
            // Trate o erro conforme necessário
            return array('status' => 'erro', 'mensagem' => $responseData);
        } else {
            // Sucesso, retorna o status do pagamento
            return array(
                'status' => 'sucesso',
                'status_pagamento' => $responseData['status'],
                'detalhes_pagamento' => $responseData
            );
        }
    }

    public function reembolsar($payment_id){
        $accessToken = $this->mp_access_token;
        $endpoint = "https://api.mercadopago.com/v1/payments/{$payment_id}/refunds";

        // Dados para a requisição
        $data = [
            'metadata' => [
                'reason' => 'Cancelamento de corrida'
            ]
        ];

        // Configurações da requisição cURL
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e captura a resposta
        $response = curl_exec($ch);
        $responseData = json_decode($response, true);
        curl_close($ch);

        if (isset($responseData['error'])) {
            // Trate o erro conforme necessário
            return array('status' => 'erro', 'mensagem' => $responseData);
        } else {
            // Sucesso
            return array('status' => 'sucesso', 'mensagem' => 'Reembolso realizado com sucesso');
        }
    }
}
