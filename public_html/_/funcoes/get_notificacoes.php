<?php 
include "../classes/alertas.php";
$a = new alertas();
$cidade_id = $_POST['cidade_id'];
$last_id = $_POST['last_id'];
$alertas = $a->getAlertas($cidade_id, $last_id);
echo json_encode($alertas);
?>
