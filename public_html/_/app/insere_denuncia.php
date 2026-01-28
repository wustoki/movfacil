<?php 
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/denuncias.php");
include("../classes/corridas.php");
include("../classes/alertas.php");
include("../classes/send_mail.php");
include("../classes/clientes.php");
include("../classes/motoristas.php");

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
$bloquear_motorista = $_POST['bloquear_motorista'];

$dados_corrida = $c->get_corrida_id($corrida_id);
$cidade_id = $dados_corrida['cidade_id'];
$cliente_id = $dados_corrida['cliente_id'];
$motorista_id = $dados_corrida['motorista_id'];
$dados_cliente = $cl->get_cliente_id($cliente_id);
$email = $dados_cliente['email'];
if($bloquear_motorista != true){
    $motorista_id = 0;
}

$denuncia_id = $d->insere($cidade_id, $corrida_id, $motivo, $origem, $descricao, $cliente_id, $motorista_id);
$a ->insereAlerta($cidade_id, "Nova denúncia adicionada", "denuncias.php");

$corpo = "<p>Olá, <strong>" . $dados_cliente['nome'] . "</strong></p>";
$corpo .= "<p>Recebemos sua denúncia referente a corrida de número <strong>" . $corrida_id . "</strong></p>";
$corpo .= "<p>Sentimos muito pelo ocorrido e queremos assegurar que estamos tomando providências para que situações como essa não voltem a acontecer. Agradecemos por entrar em contato e relatar o incidente. A Wustoki Mobilidade não tolera esse tipo de conduta, e sua segurança é nossa prioridade. Obrigado pela confiança.</p>";

// Adicionando a logo após a mensagem
$corpo .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";

// Adicionando o rodapé com link
$corpo .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";
$corpo .= "<p style='text-align: center;'><a href='https://wustoki.com.br/' style='color: #007BFF; text-decoration: none;'>Visite nosso site</a></p>";

$em->sendEmail($email, "Wustoki - Denúncia recebida", $corpo);

$motorista_id_email = $dados_corrida['motorista_id'];
$dados_motorista = $m->get_motorista($motorista_id_email);
$email_motorista = $dados_motorista['email'];

$corpo_motorista = "<p>Olá, <strong>" . $dados_motorista['nome'] . "</strong></p>";

// Assunto: Orientação sobre Condutas em Viagens
$corpo_motorista .= "<p>Esperamos que você esteja bem.</p>";
$corpo_motorista .= "<p>Recebemos recentemente um relato de conduta inadequada de um usuário, e gostaríamos de abordar a questão de maneira construtiva. Acreditamos que situações como esta podem ser resolvidas com comunicação clara e objetiva. Fique atento a alguns pontos importantes durante o atendimento ao usuário.</p>";
$corpo_motorista .= "<p>Na <strong>Wustoki Mobilidade</strong>, nos empenhamos em garantir a melhor experiência possível tanto para os motoristas quanto para os usuários. Por isso, gostaríamos de reforçar algumas orientações sobre condutas que ajudam a criar um ambiente mais seguro e agradável para todos. Sabemos que imprevistos acontecem, e nosso objetivo é trabalhar juntos para melhorar continuamente.</p>";
$corpo_motorista .= "<p><strong>Evite abordagens que possam causar má interpretação ou constrangimento por parte do usuário, e nunca discuta com o usuário.</strong> Se necessário, encerre a viagem e peça que o usuário solicite outro veículo.</p>";
$corpo_motorista .= "<p>Agradecemos sua dedicação e esperamos continuar contando com seu excelente trabalho.</p>";
$corpo_motorista .= "<p>Atenciosamente,<br>Equipe Wustoki Mobilidade</p>";
$corpo_motorista .= "<p>Dúvidas? Entre em contato pelo <a href='https://wa.me/+556285259714'>WhatsApp</a>.</p>";

$corpo_motorista .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";

$corpo_motorista .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";

$em ->sendEmail($email_motorista, "Wustoki - Orientação sobre Condutas em Viagens", $corpo_motorista);

//var_dump($denuncia_id);
if ($denuncia_id) {
    echo 'ok';
} else {
    echo 'erro';
}

