<?php
//ativa display de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header('access-control-allow-origin: *');
$root = $_SERVER['DOCUMENT_ROOT'];

include '../bd/config.php';
include '../classes/transacoes_mp.php';
include '../classes/clientes.php';
$t = new transacoes_mp();
$c = new clientes();

$user_id = $_POST['user_id'];
$valor = $_POST['valor'];
$corrida_id = $_POST['corrida_id'];

$dados_cliente = $c->get_cliente_id($user_id);
$email = $dados_cliente['email'];

// Remove pontos e vírgulas do valor
$valor = str_replace(".", "", $valor);
$valor = str_replace(",", "", $valor);
//dividir por 100 
$valor = $valor / 100;

// Gera um ID único para a transação
$external_reference = uniqid();
$idempotency_key = uniqid(); // Gera uma chave única para idempotência

$accessToken = MP_ACCESS_TOKEN;
$endpoint = "https://api.mercadopago.com/v1/payments";

// Dados para a requisição
$data = [
    'transaction_amount' => (float) $valor,
    'description' => 'Pagamento corrida',
    'payment_method_id' => 'pix',
    'payer' => [
        'email' => $email
    ],
    'external_reference' => $external_reference,
    'notification_url' => 'https://wustoki.top/_/webhook/notification.php' // URL do seu webhook
];

// Configurações da requisição cURL
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken",
    "Content-Type: application/json",
    "X-Idempotency-Key: $idempotency_key"
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
    $dados_retorno = array('status' => 'erro', 'mensagem' => $responseData);
} else {
    // Sucesso
    $transacao_id = $responseData['id'];
    $qr_code = $responseData['point_of_interaction']['transaction_data']['qr_code'];
    $qr_code_base64 = $responseData['point_of_interaction']['transaction_data']['qr_code_base64'];

    // Salva a transação no banco de dados
    $t_id = $t->insere($user_id, $external_reference, $valor, $transacao_id);
    $t->setCorrida_id($t_id, $corrida_id);
    $t->setQr_code($t_id, $qr_code);
    $t->setQr_code_base64($t_id, $qr_code_base64);

    $dados_retorno = array(
        'status' => 'sucesso',
        'external_reference' => $external_reference,
        'transacao_id' => $transacao_id,
        'qr_code' => $qr_code,
        'qr_code_base64' => $qr_code_base64
    );
}

echo json_encode($dados_retorno);