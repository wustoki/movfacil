<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
include_once "../classes/clientes.php";
include_once "../classes/sub_clientes.php";


$clientes = new Clientes();
$sub_clientes = new sub_clientes();

$nome = $_POST['nome'];
$telefone = $_POST['telefone']; 
$endereco_entrega = $_POST['endereco_entrega'];
$link_localizacao = $_POST['link_localizacao'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$telefone_cliente = $_POST['telefone_cliente'];
$senha_cliente = $_POST['senha_cliente'];

$dados_cliente = $clientes->login($telefone_cliente, $senha_cliente);

if ($dados_cliente) {
    //verifica se ja existe um subcliente com o mesmo telefone
    $sub_cliente_existente = $sub_clientes->getByTelefone($telefone);
    if ($sub_cliente_existente) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Já existe um cliente cadastrado com este telefone.']);
        exit;
    }
    $user_id = $dados_cliente['id']; 
    $cadastro = $sub_clientes->insere($user_id, $nome, $endereco_entrega, $latitude, $longitude, $telefone);
    if ($cadastro) {
        echo json_encode(['status' => 'sucesso']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao cadastrar subcliente.']);
    }
} else {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Telefone ou senha inválidos.',
        'post_data' => $_POST
    ]);
}



?>