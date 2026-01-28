<?php 
include ("../classes/avaliacoes.php");
include ("../classes/corridas.php");

$a = new avaliacoes();
$m = new corridas();

$corrida_id = $_POST['corrida_id'];
$nota = $_POST['nota'];
$comentario = $_POST['comentario'];

$dados_corrida = $m->get_corrida_id($corrida_id);
$motorista_id = $dados_corrida['motorista_id'];
$cliente_id = $dados_corrida['cliente_id'];

$a->insere($cliente_id, $motorista_id, $nota, $comentario, $corrida_id, 'cliente');
echo json_encode(array('status' => 'ok', 'mensagem' => 'Avaliação inserida com sucesso'));
?>