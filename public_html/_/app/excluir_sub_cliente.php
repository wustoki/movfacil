<?php
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/sub_clientes.php");
include_once "../classes/clientes.php";

$sub_clientes = new sub_clientes();
$c = new Clientes();

$telefone = $_POST['telefone_cliente'];
$senha = $_POST['senha_cliente'];

$cliente = $c->login($telefone, $senha);
if ($cliente) {
    $id = $_POST['id'];
    $excluir = $sub_clientes->excluir($id);
    if ($excluir) {
        $response = [
            "status" => "sucesso",
            "message" => "Cliente excluído com sucesso."
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "Erro ao excluir cliente. Tente novamente."
        ];
    }
} else {
    $response = [
        "status" => "error",
        "message" => "Cliente não encontrado. ID: " . $id . " inválido ou credenciais inválidas."
    ];
}

echo json_encode($response);