<?php

header("Access-Control-Allow-Origin: *");
http_response_code(200);
include '../classes/transacoes_mp.php';
include '../classes/corridas.php';
include '../bd/config.php';

$t = new transacoes_mp();
$c = new corridas();

// Recebe os eventos de webhook do Mercado Pago
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Verifica se a notificação contém o ID do pagamento
if (isset($data['data']['id'])) {
    $payment_id = $data['data']['id']; // ID do pagamento recebido no webhook

    // Faz uma requisição à API do Mercado Pago para obter os detalhes do pagamento
    $accessToken = MP_ACCESS_TOKEN;
    $endpoint = "https://api.mercadopago.com/v1/payments/$payment_id";

    // Configuração da requisição cURL
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $accessToken"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executa a requisição e captura a resposta
    $response = curl_exec($ch);
    $responseData = json_decode($response, true);
    curl_close($ch);

    if (isset($responseData['status'])) {
        // Obtém o status do pagamento
        $payment_status = $responseData['status']; // 'approved', 'pending', 'rejected', etc.
        $external_reference = $responseData['external_reference'];

        // Atualiza o status no banco de dados
        $t->alteraStatus($payment_id, $payment_status);
        $t->inserePayment_id($payment_id, $payment_id); // Caso precise armazenar o payment_id
        $t->alteraIntentStatus($payment_id, $payment_status);

        $transacao = $t->getByTransacaoId($payment_id);
        $corrida_id = $transacao['corrida_id'];
        if($payment_status == 'approved'){
            $dados_corrida = $c->get_corrida_id($corrida_id);
            $status_atual = $dados_corrida['status'];
            if($status_atual == 6){
                $c->set_status($corrida_id, 0);
            }
        }

        // Log para monitoramento
        $fp = fopen("log.txt", "a");
        fwrite($fp, $json . " | External Reference: " . $external_reference . " | Status: " . $payment_status . "\n");
        fclose($fp);
    } else {
        // Em caso de erro na requisição ou se o status não estiver disponível
        $fp = fopen("log.txt", "a");
        fwrite($fp, "Erro ao verificar o status do pagamento: " . $json . "\n");
        fclose($fp);
    }
} else {
    // Log para notificações sem ID de pagamento
    $fp = fopen("log.txt", "a");
    fwrite($fp, "Notificação inválida: " . $json . "\n");
    fclose($fp);
}
