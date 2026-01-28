<?php
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/corridas.php");
include_once "../classes/clientes.php";
include_once "../classes/motoristas.php";
include_once "../classes/mensagens.php";
include_once "../classes/avaliacoes.php";
include_once "../classes/transacoes_mp.php";
include_once "../classes/locacoes.php";

$crr = new corridas();
$c = new Clientes();
$m = new Motoristas();
$msg = new mensagens();
$a = new avaliacoes();
$t = new transacoes_mp();
$l = new locacoes();

$senha = $_POST['senha'];
$telefone = $_POST['telefone'];

$cliente = $c->login($telefone, $senha);

if ($cliente) {
    $cliente_id = $cliente['id'];
    $resposta = array();
    $corridas = $crr->get_all_corridas_cliente($cliente_id);
    //pega a última corrida
    if ($corridas) {
        $corrida = $corridas[0];
        $status = $corrida['status'];
        $status_string = $crr->status_string($status);
        if ($status == 1 || $status == 2 || $status == 3 || $status == 4) {
            $dados_motorista = $m->get_motorista($corrida['motorista_id']);
            $nota = $a->get_media_avaliacoes($dados_motorista['id']);
            $resposta['nivel'] = $a->getNivelMotorista($nota);
            $nota = number_format($nota, 2, '.', '');
            //busca total corridas motorista
            $total_corridas = $crr->getTotalCorridasMotorista($dados_motorista['id']);
            $resposta['total_corridas'] = $total_corridas;
            $resposta['motorista'] = $dados_motorista['nome'];
            $resposta['motorista_id'] = $dados_motorista['id'];
            $resposta['motorista_img'] = $dados_motorista['img'];
            $resposta['latitude'] = $dados_motorista['latitude'];
            $resposta['longitude'] = $dados_motorista['longitude'];
            $resposta['motorista_nome'] = $dados_motorista['nome'];
            $resposta['avaliacao'] = $nota;

            //busca se tem uma locação ativa para o motorista
            $locacao = $l->getByMotoristaId($dados_motorista['id']);
            //se tiver, pega a placa do veículo e o modelo
            if ($locacao) {
                $resposta['placa'] = $locacao[0]['placa'];
                $resposta['veiculo'] = $locacao[0]['modelo'] . " " . $locacao[0]['cor'];
            } else { //se não tiver, pega a placa do veículo e o modelo do cadastro motorista
                $resposta['placa'] = $dados_motorista['placa'];
                $resposta['veiculo'] = $dados_motorista['veiculo'];
            }
        } elseif ($status == 6) { //aguara pagamento 
            $dados_transacao = $t->getByCorridaId($corrida['id']);
            $resposta['qr_code'] = $dados_transacao['qr_code'];
            $resposta['qr_code_base64'] = $dados_transacao['qr_code_base64'];
            $resposta['transacao_id'] = $dados_transacao['transacao_id'];
        }
        $resposta['status'] = $status;
        $resposta['status_string'] = $status_string;
        $resposta['id'] = $corrida['id'];
        $resposta['taxa'] = $corrida['taxa'];

        $mensagens = $msg->get_all_msg($corrida['id']);
        if ($mensagens) {
            $resposta['msg'] = $mensagens;
        } else {
            $resposta['msg'] = "";
        }

        echo json_encode($resposta);
    } else {
        echo json_encode(array("status" => 0));
    }
}
