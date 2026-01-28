<?php 
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/corridas.php");
include("../classes/status_historico.php");
include("../classes/clientes.php");

$corridas = new corridas();
$status_historico = new status_historico();
$clientes = new clientes();
$cidade_id = $_POST['cidade_id'];
$endereco_ini = $_POST['endereco_ini'];
$endereco_fim = $_POST['endereco_fim'];
$categoria_id = $_POST['categoria_id'];
$lat_ini = $_POST['lat_ini'];
$lng_ini = $_POST['lng_ini'];
$lat_fim = $_POST['lat_fim'];
$lng_fim = $_POST['lng_fim'];
$nome = $_POST['nome'];
$km = $_POST['km'];
$tempo = $_POST['tempo'];
$taxa = $_POST['taxa'];
$telefone = $_POST['telefone'] ?? ''; 
$senha = $_POST['senha'] ?? '';
if($telefone && $senha) {
    $cliente = $clientes->login($telefone, $senha);
    if ($cliente) {
        $cliente_id = $cliente['id'];
    } else{
        $cliente_id = 0; // Se não encontrar o cliente, define como 0
    }
}else {
    $cliente_id = 0; // Se não passar telefone e senha, define como 0
} 

if($_POST['forma_pagamento'] && $_POST['forma_pagamento'] != '0') {
    $forma_pagamento = $_POST['forma_pagamento'];
}else {
    $forma_pagamento = 'Combinar com Cliente'; // Valor padrão se não for especificado
}

$id = $corridas->insere_corrida(0, $cliente_id, $cidade_id, $lat_ini, $lng_ini, $lat_fim, $lng_fim, $km, $tempo, $endereco_ini, $endereco_fim, $taxa, $forma_pagamento, 0, 0, 0, $categoria_id, $nome);
//alterar o status mais tarde
if (isset($_POST['telefone_sub_cliente']) && !empty($_POST['telefone_sub_cliente'])) {
    $telefone_sub_cliente = $_POST['telefone_sub_cliente'];
    $corridas->setTelefoneCliente($id, $telefone_sub_cliente);
}
$status_historico->salva_status($id, "Corrida solicitada", "Painel de Controle");
echo json_encode(array("id" => $id, "status" => "ok"));

?>
