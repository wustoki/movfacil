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

    // Sucesso
    $transacao_id = "teste";
    $qr_code = "teste_qr_code";
    $qr_code_base64 = "teste_qr_code_base64";

    // Salva a transação no banco de dados
    var_dump($t->insere($user_id, $external_reference, $valor, $transacao_id));
    $dados_retorno = array(
        'status' => 'sucesso',
        'external_reference' => $external_reference,
        'transacao_id' => $transacao_id,
        'qr_code' => $qr_code,
        'qr_code_base64' => $qr_code_base64
    );

echo json_encode($dados_retorno);