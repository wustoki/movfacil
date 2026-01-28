<?php
header("Access-Control-Allow-Origin: *");
include '../classes/corridas.php';
include '../classes/configuracoes_pagamento.php';
include '../classes/status_historico.php';


/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/

if ($alterou) {
    echo "1";
} else {
    echo "0";
}
