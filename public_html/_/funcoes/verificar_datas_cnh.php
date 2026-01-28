<?php 
header("Access-Control-Allow-Origin: *");
include("../classes/motoristas.php");
include("../classes/send_mail.php");
include "../classes/alertas.php";
$a = new alertas();

$m = new motoristas();
$email = new enviaEmail();

$motoristas = $m->get_all_motoristas();

//fuso sp
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = date('Y-m-d');
$data_hoje = strtotime($data_hoje);
//percorre os dados de cada motorista e verifica se a validade da cnh passou então bloqueia o motorista

foreach ($motoristas as $motorista) {
    $cidade_id = $motorista['cidade_id'];
    $diferenca = 0;
    $validade_cnh = $motorista['validade_cnh'];
    //se validade estiver vazia, não faz nada
    if($validade_cnh == ""){
        continue;
    }
    $validade_cnh = date('Y-m-d', strtotime($validade_cnh));
    $validade_cnh = strtotime($validade_cnh);
    
    $diferenca = $validade_cnh - $data_hoje;
    $diferenca = $diferenca / (60 * 60 * 24);
    if($diferenca < 0 && $diferenc > -7){
        $m ->bloquearMotorista($motorista['id']);
        $email->sendEmail($motorista['email'], "CNH Vencida", "Sua CNH venceu, por favor entre em contato e atualize seus dados para continuar trabalhando com a nossa plataforma!");
    }
    //se diferença estiver entre 0 e 30 dias envia email de alerta
    if($diferenca >= 0 && $diferenca <= 30){
        $email->sendEmail($motorista['email'], "CNH Vencendo", "Sua CNH está vai vencer em $diferenca dias, por favor entre em contato e atualize seus dados para continuar trabalhando com a nossa plataforma!");
    }
    if($diferenca >= 0 && $diferenca <= 7){
        $a->insereAlerta($cidade_id, "CNH do motorista ".$motorista['nome']." vencendo em $diferenca dias", "editar_motorista.php?id=".$motorista['id']);
    }
}

foreach ($motoristas as $motorista) {
    $cidade_id = $motorista['cidade_id'];
    $diferenca = 0;
    $validade_doc_veiculo = $motorista['validade_doc_veiculo'];
    //se validade estiver vazia, não faz nada
    if($validade_doc_veiculo == ""){
        continue;
    }
    $validade_doc_veiculo = date('Y-m-d', strtotime($validade_doc_veiculo));
    $validade_doc_veiculo = strtotime($validade_doc_veiculo);

    $diferenca = $validade_doc_veiculo - $data_hoje;
    $diferenca = $diferenca / (60 * 60 * 24);
    if($diferenca < 0){
        $m ->bloquearMotorista($motorista['id']);
        $email->sendEmail($motorista['email'], "Documento do Veículo Vencido", "O documento do seu veículo venceu, por favor entre em contato e atualize seus dados para continuar trabalhando com a nossa plataforma!");
    }
    //se diferença estiver entre 0 e 30 dias envia email de alerta
    if($diferenca >= 0 && $diferenca <= 30){
        $email->sendEmail($motorista['email'], "Documento do Veículo Vencendo", "O documento do seu veículo vai vencer em $diferenca dias, por favor entre em contato e atualize seus dados para continuar trabalhando com a nossa plataforma!");
    }
    if($diferenca >= 0 && $diferenca <= 7){
        $a->insereAlerta($cidade_id, "Documento do veículo do motorista ".$motorista['nome']." vencendo em $diferenca dias", "editar_motorista.php?id=".$motorista['id']);
    }
}


?>