<?php 
header('access-control-allow-origin: *');
include_once "../classes/clientes.php";
include ("../classes/corridas.php");
include ("../classes/avaliacoes.php");
include("../classes/corridas_a_avaliar.php");

$c = new Clientes();
$m = new corridas();
$a = new avaliacoes();
$ca = new corridas_a_avaliar();

$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
$cliente = $c ->login($telefone, $senha);
if($cliente){
    
    //verifica se o cliente já avaliou essa corrida
    $corrida_id = $_POST['corrida_id'];
    if($a ->verifica_avaliacao_motorista($corrida_id)){
        echo json_encode(array('status' => 'erro', 'mensagem' => 'Você já avaliou essa corrida'));
        exit();
    }

    $nota = $_POST['nota'];
    $comentario = $_POST['comentario'];
    $cliente_id = $cliente['id'];
    $corrida = $m-> get_corrida_id($corrida_id);
    $motorista_id = $corrida['motorista_id'];
    $a->insere($cliente_id, $motorista_id, $nota, $comentario, $corrida_id, 'motorista');
    $ca->deleteAllFromUserId($cliente_id);
    echo json_encode(array('status' => 'ok', 'mensagem' => 'Avaliação inserida com sucesso'));
}

?>