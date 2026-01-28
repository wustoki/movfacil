<?php
include("../classes/motoristas.php");
include("../classes/veiculos.php");
include("../classes/locacoes.php");

$m = new motoristas();
$v = new veiculos();
$l = new locacoes();

$id_veiculo = $_POST['veiculo_id'];
$id_motorista = $_POST['motorista_id'];
$km_inicial = $_POST['km_inicial'];

$veiculo = $v->getById($id_veiculo);

//insere a locação
$id_locacao = $l->insere($id_veiculo, $id_motorista, $km_inicial);
$v ->setKmAtual($id_veiculo, $km_inicial);

echo "<script>alert('Locação realizada com sucesso!');</script>";
echo "<script>location.href = 'veiculos.php';</script>";


?>

