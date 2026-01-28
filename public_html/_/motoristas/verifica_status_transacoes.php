<?php
header('access-control-allow-origin: *');
include_once "../classes/transacoes_motoristas.php";
include '../classes/configuracoes_pagamento.php';
include_once "../classes/motoristas.php";


/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/

if($alterou){
    echo json_encode(array('status' => 'ok'));
}else{
    echo json_encode(array('status' => 'no'));
}
?>