<?php 
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/corridas.php");
include("../classes/status_historico.php");
include_once "../classes/clientes.php";
include_once "../classes/transacoes.php";
include '../classes/cupons.php';


$corridas = new corridas();
$status_historico = new status_historico();
$c = new Clientes();
$cupons = new cupons();


$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
$valor = $_POST['valor'];

$cliente = $c ->login($telefone, $senha);
$resposta = array();
if($cliente){
$cidade_id = $cliente['cidade_id'];
$nome = $cliente['nome'];
$cliente_id = $cliente['id'];
$transacoes = new transacoes($cidade_id);
$forma_pagamento = $_POST['forma_pagamento'];
$endereco_ini = $_POST['endereco_ini'];
$endereco_fim = $_POST['endereco_fim'];
$categoria_id = $_POST['categoria_id'];
$lat_ini = $_POST['lat_ini'];
$lng_ini = $_POST['lng_ini'];
$lat_fim = $_POST['lat_fim'];
$lng_fim = $_POST['lng_fim'];

$km = $_POST['km'];
$tempo = $_POST['tempo'];
$taxa = $_POST['taxa']; 

$status = $_POST['status'];

$qnt_usuarios = $_POST['qnt_usuarios'];
if (isset($_POST['cupon'])&&$_POST['cupon']!=""){
    $cupon = addslashes($_POST['cupon']);
    $dados_cupon = $cupons->get_cupon_nome($cupon, $cidade_id);
    $cupons->add_cupon_used($cidade_id, $cupon, $cliente_id);
    $cupons->diminui_quantidade($dados_cupon['id']);
}
$id = $corridas->insere_corrida(0, $cliente_id, $cidade_id, $lat_ini, $lng_ini, $lat_fim, $lng_fim, $km, $tempo, $endereco_ini, $endereco_fim, $taxa, $forma_pagamento, 0, 0, 0, $categoria_id, $nome, $qnt_usuarios);
$corridas->set_status($id, $status);

$status_historico->salva_status($id, "Corrida solicitada", "Aplicativo");
echo json_encode(array("id" => $id, "status" => "ok"));
}
