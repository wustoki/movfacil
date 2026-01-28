<?php
include("../classes/motoristas.php");
include("../classes/locacoes.php");
$l = new locacoes();

$id_motorista = $_POST['id_motorista'];

$locacoes = $l->getByMotoristaId($id_motorista);

echo ($locacoes === false) ? "no" : json_encode($locacoes);