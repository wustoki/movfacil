<?php
header('access-control-allow-origin: *');
include '../classes/transacoes_mp.php';
include_once '../classes/corridas.php';

$c = new corridas();
$t = new transacoes_mp();

$transacao_id = $_POST['transacao_id'];

$corrida_id = $t->getByTransacaoId($transacao_id)['corrida_id'];
$t ->alteraStatus($transacao_id, "cancelled");
$c->set_status($corrida_id, 5);
echo "ok";
?>