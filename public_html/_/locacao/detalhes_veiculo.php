<?php
header('access-control-allow-origin: *');
include_once "../classes/veiculos.php";

$veiculos = new Veiculos();

$id = $_POST['id'];

$veiculo = $veiculos->getById($id);

if($veiculo){
    $retorno = array(
        "status" => "ok",
        "veiculo" => $veiculo
    );
}else{
    $retorno = array(
        "status" => "erro",
        "erro" => "Veículo não encontrado"
    );
}

echo json_encode($retorno);

?>