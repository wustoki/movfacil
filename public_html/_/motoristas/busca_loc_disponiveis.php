<?php
include("../classes/motoristas.php");
include("../classes/veiculos.php");

$v = new veiculos();

$cidade_id = $_POST['cidade_id'];

$veiculos = $v->getByCidadeId($cidade_id);

echo ($veiculos === false) ? "no" : json_encode($veiculos);