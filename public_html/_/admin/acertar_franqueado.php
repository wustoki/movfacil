<?php 
include "../classes/acertos_franqueados.php";
include "../classes/franqueados.php";
include("../classes/transacoes_motoristas.php");
include_once "../classes/send_mail.php";
$a = new acertos_franqueados();
$f = new franqueados();
$sm = new enviaEmail();
$franqueado_id = $_POST['franqueado_id'];
$semana = $_POST['semana'];
$valor = $_POST['valor'];
$valor_bruto = $_POST['valor_bruto'];
$acerto = $a->getByFranqueado($franqueado_id, $semana);
if($acerto){
    echo "Acerto já realizado!";
}else{
    $acerto = $a->insere($franqueado_id, $semana, "FEITO", $valor);
    if($acerto){
        $data_to_br = explode(" ", $semana)[0];
        $data_to_br = explode("-", $data_to_br);
        $data_br = $data_to_br[2]."/".$data_to_br[1]."/".$data_to_br[0];
        $dados_franqueado = $f->get_usuario_id($franqueado_id);
        $msg = "Olá ".$dados_franqueado['nome'].",<br><br>";
        $msg .= "Seu acerto referente a semana ".$data_br." foi realizado com sucesso. <br><br>";
        $msg .= "Valor da sua comissão: R$ ".$valor_bruto."<br><br>";
        $msg .= "O valor já foi enviado para sua conta bancária. <br><br>";
        $msg .= "Atenciosamente <br>";
        $msg .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";
        $msg .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";
        $assunto = "Acerto Semanal Realizado";

        $sm->sendEmail($dados_franqueado['email'], $assunto, $msg);
        echo "Acerto realizado com sucesso!";
    }else{
        echo "Erro ao realizar acerto!";
    }
}

?>