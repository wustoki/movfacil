<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
include_once "../classes/clientes.php";
include_once "../classes/sub_clientes.php";

$telefone_cliente = $_POST['telefone_cliente'];
$senha_cliente = $_POST['senha_cliente'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$endereco_entrega = $_POST['endereco_entrega'];
$id = $_POST['id'];

$clientes = new Clientes();
$sub_clientes = new sub_clientes();

$dados_cliente = $clientes->login($telefone_cliente, $senha_cliente);

if ($dados_cliente) {
    $sub_clientes->editarSubCliente($id, $nome, $telefone, $endereco_entrega);
    echo json_encode(['status' => 'sucesso']);
} else {
    echo json_encode(['status' => 'erro']);
    exit;
}
