<?php 
include "../classes/acertos.php";
include "../classes/motoristas.php";
include("../classes/transacoes_motoristas.php");
$a = new acertos();
$m = new motoristas();
$motorista_id = $_POST['motorista_id'];
$semana = $_POST['semana'];
$valor = $_POST['valor'];
$valor_bruto = $_POST['valor_bruto'];
$acerto = $a->getByMotorista($motorista_id, $semana);
if($acerto){
    echo "Acerto já realizado!";
}else{
    $acerto = $a->insere($motorista_id, $semana, "FEITO", $valor);
    $dados_motorista = $m->get_motorista($motorista_id);
    $saldo = $dados_motorista['saldo'];
    $cidade_id = $dados_motorista['cidade_id'];
    $tm = new transacoes_motoristas($cidade_id);
    //se saldo for negativo
    if($saldo < 0){
        $novo_saldo = "0,00";
        //salva o novo saldo
        $m->atualiza_saldo($motorista_id, $novo_saldo);
        //insere transação
        
        //remove o - do saldo
        $saldo = str_replace('-', '', $saldo);
        $tm->insereTransacao($motorista_id, 'N/A', $saldo, 'CREDITO SALDO ACERTO SEMANAL', 'CONCLUIDO');
    }
    
    $tm->insereTransacao($motorista_id, 'N/A', $valor, 'DÉBITO ACERTO SEMANAL', 'CONCLUIDO');

    if($acerto){
        echo "Acerto realizado com sucesso!";
    }else{
        echo "Erro ao realizar acerto!";
    }
}

?>