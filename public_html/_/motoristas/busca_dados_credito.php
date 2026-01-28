<?php
include("../classes/motoristas.php");
include("../classes/corridas.php");

$m = new Motoristas();
$c = new corridas();

$motorista_id = $_POST['motorista_id'];
$dados_motorista = $m->get_motorista($motorista_id);

$corridas = $c->getCorridasSemana($motorista_id);
$valor_corridas = 0; 
foreach ($corridas as $corrida) {
    if($corrida['f_pagamento'] == "Pix" || $corrida['f_pagamento'] == "Carteira Crédito"){
        $valor_corridas += str_replace(',', '.', $corrida['taxa']);
    }
} 

$limite_credito = $dados_motorista['limite_credito'];
$saldo = $dados_motorista['saldo'];
$saldo = str_replace(',', '.', $saldo);
$taxa_motorista = $dados_motorista['taxa'];

$comissao = $valor_corridas * $taxa_motorista / 100;

//referenta ao limite de saldo
if($saldo < 0){
    $limite_saldo = $limite_credito + $saldo;
} else {
    $limite_saldo = $limite_credito;
}



$dados = array();

//se saldo for negativo $valor_corridas recebe o valor do saldo mais o valor das corridas
if($saldo < 0){
    $valor_corridas = $valor_corridas + $saldo;
} else {
    $valor_corridas = $saldo;
}

//se valor_corridas for maior que 0 o limite de saldo recebe o valor das corridas como um limite dinamico
if($valor_corridas > 0){
    $limite_saldo += $valor_corridas;
}


$dados['limite_saldo'] = number_format($limite_saldo, 2, ',', '.');
$dados['saldo'] = $saldo;
$dados['valor_corridas'] = $valor_corridas;

echo json_encode($dados);

?>