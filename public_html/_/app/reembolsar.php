<?php
header("access-control-allow-origin: *");
include("../classes/mp.php");

$mp = new MP();

$transacao_id = $_POST['transacao_id'];
if($transacao_id != "" && $transacao_id != null){
    $mp->reembolsar($transacao_id);
}
echo "ok";
?>