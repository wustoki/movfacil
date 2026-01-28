<?php
// Define que a origem do acesso pode ser de qualquer lugar
header('access-control-allow-origin: *');

// Inclui as classes necessárias
include_once "../classes/clientes.php";
include_once "../classes/cpf.php";
include_once "../classes/send_mail.php";
include "../classes/alertas.php";

// Cria instâncias das classes
$clientes = new Clientes();
$cp = new cpf();
$mail = new enviaEmail();
$a = new alertas();

// Recebe os dados do formulário enviados via POST
$cidade_id = $_POST['cidade_id'];
$nome = $_POST['nome'];
$numero_telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];

//---------------------------------------------------------
// (REMOVIDO O reCAPTCHA) – daqui em diante segue o fluxo original
//---------------------------------------------------------

// Define o salt para o hash da senha
$salt = "anjdsn5s141d5";
// Cria o hash da senha
$senha = md5($senha.$salt);

// Limpa e formata o número de telefone
$numero_telefone = str_replace("(", "", $numero_telefone);
$numero_telefone = str_replace(")", "", $numero_telefone);
$numero_telefone = str_replace("-", "", $numero_telefone);
$numero_telefone = str_replace(" ", "", $numero_telefone);

// Verifica se o telefone já existe
$verifica = $clientes->verifica_se_existe($numero_telefone);
if($verifica){
    echo json_encode(array("status" => "Telefone já cadastrado"));
    exit;
}

// Valida o CPF
if(!$cp->validar($cpf)){
    echo json_encode(array("status" => "CPF inválido"));
    exit;
}

// Cadastra o cliente no banco de dados
$cadastra = $clientes->cadastra($cidade_id, $nome, $numero_telefone, $senha, $latitude, $longitude, $cpf, $email);
if($cadastra){
    // Envia o e-mail de confirmação de cadastro
    $mail->sendEmail($email, "Cadastro realizado com sucesso",
    "Obrigado por se cadastrar no app Wustoki. Agora você já pode chamar o seu motorista e contar com a gente para te levar aonde você quiser. Aproveite!");
    
    // Insere o alerta para o novo usuário
    $a ->insereAlerta($cidade_id, "Novo usuário cadastrado: $nome", "listar_clientes.php");
    
    echo json_encode(array("status" => "sucesso"));
}else{
    // Retorna erro se o cadastro falhar
    echo json_encode(array("status" => "erro"));
}
?>