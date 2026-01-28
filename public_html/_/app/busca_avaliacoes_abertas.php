<?php
header("access-control-allow-origin: *");
include("../classes/corridas_a_avaliar.php");

$ca = new corridas_a_avaliar();

$user_id = $_POST['user_id'];
$abertas  = $ca ->getByUserId($user_id);
if($abertas){
    $corrida_id = $abertas['corrida_id'];
    echo json_encode(array('status' => 'ok', 'corrida_id' => $corrida_id));
}else{
    echo json_encode(array('status' => 'no', 'mensagem' => 'Nenhuma corrida a avaliar'));
}