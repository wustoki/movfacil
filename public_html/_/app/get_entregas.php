<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);  
error_reporting(E_ALL);
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/corridas.php");
include_once "../classes/clientes.php";

$crr = new corridas();
$c = new Clientes();


$senha = $_POST['senha'];
$telefone = $_POST['telefone'];

$cliente = $c->login($telefone, $senha);

if ($cliente) {
    $cliente_id = $cliente['id'];
    $corridas = $crr->getCorridasClienteAbertas($cliente_id);

    // percorre as corridas para adicionar o status texto
    foreach ($corridas as &$corrida) {
        $corrida['status_texto'] = $crr->status_string($corrida['status']);
    }
    unset($corrida);

    $response = [
        'status' => 'success',
        'entregas' => $corridas
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = [
        'status' => 'error',
        'message' => 'Cliente não encontrado ou credenciais inválidas.',
        'entregas' => []
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
