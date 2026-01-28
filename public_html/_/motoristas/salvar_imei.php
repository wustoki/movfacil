<?php 
include ("../classes/motoristas.php");
include_once "../classes/send_mail.php";
$m = new motoristas();
$sm = new enviaEmail();

$motorista_id= $_POST['motorista_id'];
$imei = $_POST['imei'];
$tipo = $_POST['tipo'];
if($tipo == "insere"){
$motorista = $m->get_motorista($motorista_id);
$imei_motorista = $motorista['imei'];
//se $imei for diferente de  $imei_motorista envia email
$msg = "Olá ".$motorista['nome'].",<br><br>";
$msg .= "Detectamos um login em sua conta Wustoki realizado em um novo dispositivo. Caso tenha sido você, não é necessário se preocupar. Aqui estão os detalhes do acesso: <br><br>";
$msg .= "Data: ".date("d/m/Y H:i:s")."<br>";
$msg .= "Dispositivo: ".$_SERVER['HTTP_USER_AGENT']."<br>";
$msg .= "IP: ".$_SERVER['REMOTE_ADDR']."<br>";
$msg .= "Se você reconhece este acesso, pode ignorar este e-mail.  <br><br>";
$msg .= "<b>⚠️ Não reconhece este login?</b><br><br>";
$msg .= "1 .Altere sua senha imediatamente em nosso aplicativo. <br>";
$msg .= "2. Entre em contato com nossa equipe de suporte pelo <a href='https://wa.me/+556285259714'>WhatsApp</a>". "<br><br>";
$msg .= "A segurança de sua conta é nossa prioridade. Para mais dicas de segurança, acesse nosso site ou fale com nossa equipe.  ,<br>";
$msg .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";
$msg .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";

$assunto = "Alerta de Segurança: Novo Login Detectado em Outro Dispositivo";

if($imei != $imei_motorista && $imei_motorista != ""){
    $sm->sendEmail($motorista['email'], $assunto, $msg);
}


$m->setImei($motorista_id, $imei);
echo json_encode(array('status' => 'ok', 'mensagem' => 'IMEI inserido com sucesso', 'modo' => 'insere'));


}else{
    //busca dados do motorista
    $motorista = $m->get_motorista($motorista_id);
    echo json_encode(
        array(
            'status' => 'ok',
            'modo' => 'busca',
            'mensagem' => 'IMEI encontrado',
            'dados' => $motorista
        )
    );
}

?>