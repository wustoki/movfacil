<?php
header('access-control-allow-origin: *');
include_once "../classes/clientes.php";
include_once "../classes/veiculos.php";

$clientes = new Clientes();
$veiculos = new Veiculos();

$telefone = $_POST['telefone'];
$senha = $_POST['senha'];

$cliente = $clientes->login($telefone, $senha); // Changed $c to $clientes
if($cliente){
    $id = $_POST['id'];
    //exclude vehicle
    $veiculos->excluir($id);
    $retorno = array(
        "status" => "ok"
    );
}else{
    $retorno = array(
        "status" => "erro",
        "erro" => "Telefone ou senha incorretos"
    );
}

echo json_encode($retorno);
