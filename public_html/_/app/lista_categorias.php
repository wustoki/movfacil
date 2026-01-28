<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
include_once "../classes/clientes.php";
include_once "../classes/categorias.php";
include_once "../classes/cidades.php";

$clientes = new Clientes();
$categorias = new Categorias();
$cidades = new Cidades();


// Recebe dados JSON do corpo da requisição
$input = json_decode(file_get_contents('php://input'), true);
$telefone_cliente = isset($input['telefone_cliente']) ? $input['telefone_cliente'] : '';
$senha_cliente = isset($input['senha_cliente']) ? $input['senha_cliente'] : '';

$dados_cliente = $clientes->login($telefone_cliente, $senha_cliente);

if ($dados_cliente) {
    $cidade_id = $dados_cliente['cidade_id'];
    $lista_categorias = $categorias->get_categorias($cidade_id, true);
    $dados_cidade = $cidades->get_dados_cidade($cidade_id);
    echo json_encode([
        'status' => 'ok',
        'categorias' => $lista_categorias,
        'cidade' => $dados_cidade
    ]);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Telefone ou senha inválidos.']);
}
?>
