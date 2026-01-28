<?php
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/sub_clientes.php");
include_once "../classes/clientes.php";

$sub_clientes = new sub_clientes();
$c = new Clientes();

$telefone = $_POST['telefone'];
$senha = $_POST['senha'];

$cliente = $c->login($telefone, $senha);

if ($cliente) {
    $cliente_id = $cliente['id'];

    $lista_sub_clientes = $sub_clientes->getByUserId($cliente_id);

    if ($lista_sub_clientes) {
        $response = [
            'status' => 'success',
            'clientes' => $lista_sub_clientes
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Nenhum cliente encontrado.',
            'clientes' => []
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Cliente não encontrado ou credenciais inválidas.',
        'clientes' => []
    ];
}

header('Content-Type: application/json');
echo json_encode($response);