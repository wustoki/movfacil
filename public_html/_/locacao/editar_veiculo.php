<?php
include("../bd/config.php");
include_once "../classes/clientes.php";
include_once "../classes/veiculos.php";

$c = new clientes();
$v = new veiculos();


$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$cliente = $c->login($telefone, $senha);
if($cliente){
    //editar
    $id = $_POST['id'];
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = $_POST['ano'];
    $cor = $_POST['cor'];
    $categoria = $_POST['categoria'];
    $tipo_combustivel = $_POST['tipo_combustivel'];
    $v->editar($id, $placa, $modelo, $marca, $ano, $cor, $categoria, $tipo_combustivel);
    echo "<script>alert('Veículo editado com sucesso!');</script>";
    echo "<script>location.href = 'veiculos.php';</script>";
}else{
    echo "<script>alert('Usuário ou senha inválidos!');</script>";
    echo "<script>location.href = 'veiculos.php';</script>";
}