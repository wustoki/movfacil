<?php
header('Access-Control-Allow-Origin: *');
include '../classes/mp.php';
include '../classes/transacoes_mp.php';

$mp = new MP();
$t = new transacoes_mp();

$transacao_id = $_POST['transacao_id'];
$resultado = $mp->verificarStatusPagamento($transacao_id);
$status = $resultado['status_pagamento'];

$t ->alteraStatus($transacao_id, $status);

if($status == "cancelled"){
    $status = "cancelado";
}else if($status == "rejected"){
    $status = "cancelado";
}

if($status == "approved"){
    $t->alteraIntentStatus($transacao_id, "FINISHED");
}



$resposta = array(
    'status' => 'ok',
    'status_pagamento' => $status
);

echo json_encode($resposta);

?>
