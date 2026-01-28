<?php
include "seguranca.php";
include "../classes/denuncias.php";
$d = new denuncias();
$d->del_denuncia($_GET['id']);
echo "<script>alert('Denúncia deletada com sucesso!');</script>";
echo "<script>window.location.href='denuncias.php';</script>";
?>