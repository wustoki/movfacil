<?php
include "../painel/seguranca.php";
include "../classes/corridas.php";
include "../classes/status_historico.php";

$c = new corridas();
$sh = new status_historico();

$id = $_POST['id'];
$status = $_POST['status'];

$c ->set_status($id, $status);
$sh->salva_status($id, $c->status_string($status), $_POST['origem']);

?>