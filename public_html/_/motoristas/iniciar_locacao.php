<?php
include("../classes/motoristas.php");
include("../classes/veiculos.php");
include("../classes/locacoes.php");

$m = new motoristas();
$v = new veiculos();
$l = new locacoes();

$cidade_id = $_POST['cidade_id'];
$id_veiculo = $_POST['id_veiculo'];
$id_motorista = $_POST['id_motorista'];
$km_inicial = $_POST['km_inicial'];

$veiculos = $v->getByCidadeId($cidade_id);

if($veiculos === false){
    echo "no";
}else{
    $encontrou = false;
    foreach($veiculos as $veiculo){
        if($veiculo['id'] == $id_veiculo){
            $id_locacao = $l->insere($id_veiculo, $id_motorista, $km_inicial);
            echo $id_locacao; //responde com o id da locacao
            $encontrou = true;
            break;
        }
    }
    if(!$encontrou){
        echo "no";
    }
}

?>

