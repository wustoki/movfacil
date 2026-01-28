<?php 
include_once "../classes/categorias_horarios.php";
$ch = new dinamico_horarios();

var_dump($ch->verifica_horario(3));
?>