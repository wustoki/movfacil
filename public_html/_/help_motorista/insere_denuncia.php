<?php
//habilita display de erros
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/denuncias.php");
include("../classes/corridas.php");
include("../classes/alertas.php");
include("../classes/send_mail.php");
include("../classes/clientes.php");
include("../classes/motoristas.php");
include("../classes/upload.php");

$d = new denuncias();
$c = new corridas();
$a = new alertas();
$em = new enviaEmail();
$cl = new clientes();
$m = new motoristas();

$corrida_id = $_POST['id'];
$motivo = $_POST['motivo'];
$descricao = $_POST['descricao'];
$origem = $_POST['origem'];

$problema_com_usuario = false;
if ($motivo == "problema-seguranca" || $motivo == "nao-pagou-viagem" || $motivo == "comentarios-negativos" || $motivo == "assedio") {
    $problema_com_usuario = true;
}


$dados_corrida = $c->get_corrida_id($corrida_id);
$cidade_id = $dados_corrida['cidade_id'];
$cliente_id = $dados_corrida['cliente_id'];
$motorista_id = $dados_corrida['motorista_id'];
$dados_cliente = $cl->get_cliente_id($cliente_id);
$email = $dados_cliente['email'];

$pasta = '../admin/uploads/';
$img = $_FILES['imagem'];

if ($img['name'] != "") {
    $upload = new Upload($img, 800, 800, $pasta);
    $nome_img = $upload->salvar();
    echo $nome_img;
} else {
    $nome_img = "sem_imagem.jpg";
}


$denuncia_id = $d->insere($cidade_id, $corrida_id, $motivo, $origem, $descricao, $cliente_id, $motorista_id);
$d->setImg($denuncia_id, $nome_img);
$a->insereAlerta($cidade_id, "Nova denúncia adicionada", "denuncias.php");

if ($problema_com_usuario) {
    $corpo = "<p>Olá, <strong>" . $dados_motorista['nome'] . "</strong></p>";
    $corpo .= "<p>Recebemos sua denúncia referente a corrida de número <strong>" . $corrida_id . "</strong></p>";
    $corpo .= "<p>Sentimos muito pelo ocorrido e queremos assegurar que estamos tomando providências para que situações como essa não voltem a acontecer. Agradecemos por entrar em contato e relatar o incidente. A Wustoki Mobilidade não tolera esse tipo de conduta, e sua segurança é nossa prioridade. Obrigado pela confiança.</p>";
} else{
    $corpo = "<p>Olá, <strong>" . $dados_cliente['nome'] . "</strong></p>";
    $corpo .= "<p>Recebemos seu pedido de suporte a corrida de número <strong>" . $corrida_id . "</strong></p>";
    $corpo .= "<p>Agradecemos por relatar o ocorrido. Caso necessário, entraremos em contato.</p>";
}


// Adicionando a logo após a mensagem
$corpo .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";

// Adicionando o rodapé com link
$corpo .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";
$corpo .= "<p style='text-align: center;'><a href='https://wustoki.com.br/' style='color: #007BFF; text-decoration: none;'>Visite nosso site</a></p>";


$motorista_id_email = $dados_corrida['motorista_id'];
$dados_motorista = $m->get_motorista($motorista_id_email);
$email_motorista = $dados_motorista['email'];

$em->sendEmail($email_motorista, "Wustoki - Denúncia recebida", $corpo);

if($problema_com_usuario){
    //envia ao usuário
$corpo = "<p>Olá, <strong>" . $dados_cliente['nome'] . "</strong></p>";
$corpo_passageiro .= "<p>Esperamos que você esteja bem.</p>";
$corpo_passageiro .= "<p>Na <strong>Wustoki Mobilidade</strong>, nossa prioridade é oferecer a melhor experiência possível para todos os nossos usuários, garantindo que as viagens sejam sempre seguras, agradáveis e respeitosas.</p>";
$corpo_passageiro .= "<p>Valorizamos muito a boa convivência e acreditamos que boas atitudes contribuem para uma comunidade mais harmoniosa, tanto para passageiros quanto para motoristas.</p>";
$corpo_passageiro .= "<p>Gostaríamos de reforçar a importância do respeito mútuo durante as viagens, pois isso fortalece a confiança e o ambiente positivo que buscamos manter.</p>";
$corpo_passageiro .= "<p>Agradecemos por fazer parte da nossa comunidade e por contribuir para que cada viagem seja uma experiência positiva.</p>";
$corpo_passageiro .= "<p>Caso tenha sugestões ou dúvidas, nossa equipe está à disposição para ajudar.</p>";
$corpo_passageiro .= "<p>Agradecemos pela sua compreensão e colaboração.</p>";
$corpo_passageiro .= "<p>Atenciosamente,<br><strong>Equipe Wustoki Mobilidade</strong></p>";
$corpo_passageiro .= "<p>Dúvidas e sugestões? Entre em contato com nossa equipe pelo WhatsApp: <a href='https://wa.me/556285259714' target='_blank'>Clique aqui</a>.</p>";
$corpo_passageiro .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";

// Adicionando o rodapé com link
$corpo_passageiro .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";
$corpo_passageiro .= "<p style='text-align: center;'><a href='https://wustoki.com.br/' style='color: #007BFF; text-decoration: none;'>Visite nosso site</a></p>";

$em->sendEmail($email, "Wustoki - Importância da Boa Convivência em Nossas Viagens", $corpo_passageiro);
}




//var_dump($denuncia_id);
if ($denuncia_id) {
    echo 'ok';
} else {
    echo 'erro';
}
