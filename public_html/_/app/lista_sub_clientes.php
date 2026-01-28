<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
include_once "../classes/clientes.php";
include_once "../classes/sub_clientes.php";


$clientes = new Clientes();
$sub_clientes = new sub_clientes();

// Recebe dados JSON do corpo da requisição
$input = json_decode(file_get_contents('php://input'), true);
$telefone_cliente = isset($input['telefone_cliente']) ? $input['telefone_cliente'] : '';
$senha_cliente = isset($input['senha_cliente']) ? $input['senha_cliente'] : '';

$dados_cliente = $clientes->login($telefone_cliente, $senha_cliente);

if ($dados_cliente) {
    $id = $dados_cliente['id'];
    $lista_sub_clientes = $sub_clientes->getByUserId($id);
    echo json_encode([
        'status' => 'ok',
        'sub_clientes' => $lista_sub_clientes
    ]);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Telefone ou senha inválidos.']);
}
?>