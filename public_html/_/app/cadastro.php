<?php
// Define que a origem do acesso pode ser de qualquer lugar
header('access-control-allow-origin: *');

// Inclui as classes necessárias
include_once "../classes/clientes.php";
include_once "../classes/send_mail.php";

// Cria instâncias das classes
$clientes = new Clientes();
$mail = new enviaEmail();

// Recebe os dados do formulário enviados via POST
$cidade_id = $_POST['cidade_id'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

//---------------------------------------------------------
// PASSO 1: VERIFICAÇÃO DO reCAPTCHA
// Esta é a parte nova que você precisa adicionar.
// Esta verificação deve ocorrer antes de qualquer operação no banco de dados.
//---------------------------------------------------------

// A sua chave secreta do reCAPTCHA (substitua por sua chave secreta real)
$recaptcha_secret_key = 'AIzaSyBPkhNhPL7qmO6ue9jqYLnIyi_3z_DgON4'; 

// O token enviado pelo formulário HTML (gerado pelo JavaScript)
$recaptcha_token = $_POST['g-recaptcha-response'];

// URL da API de verificação do Google
$url = 'https://www.google.com/recaptcha/api/siteverify';

// Prepara os dados para enviar ao Google
$data = array(
    'secret' => $recaptcha_secret_key,
    'response' => $recaptcha_token
);

// Constrói a query para a URL
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);

// Cria o contexto da requisição
$context  = stream_context_create($options);

// Faz a requisição para o Google e obtém a resposta
$response = file_get_contents($url, false, $context);

// Decodifica a resposta JSON
$response_data = json_decode($response, true);

// Verifica a resposta do Google
// O `success` será true se o token for válido e o score for alto.
if (!$response_data['success'] || $response_data['score'] < 0.5) {
    // A validação falhou. A requisição é de um robô ou o score é baixo.
    // Aborta o processo e retorna um erro para o aplicativo.
    echo json_encode(array("status" => "Erro: Verificação reCAPTCHA falhou."));
    exit;
}

//---------------------------------------------------------
// PASSO 2: CÓDIGO ORIGINAL DO SEU ARQUIVO
// Se a verificação do reCAPTCHA passou, o código continua.
//---------------------------------------------------------

// Define o salt para o hash da senha
$salt = "anjdsn5s141d5";
// Cria o hash da senha
$senha = md5($senha.$salt);

// Verifica se o telefone já existe no banco de dados
$verifica = $clientes->verifica_se_existe($telefone);
if($verifica){
    echo json_encode(array("status" => "Telefone já cadastrado"));
    exit;
}

// Cadastra o cliente no banco de dados
$cadastra = $clientes->cadastra($cidade_id, $nome, $telefone, $senha, $latitude, $longitude);
if($cadastra){
    // Envia o e-mail de confirmação de cadastro
    $mail->sendEmail(
        $telefone, 
        "Cadastro realizado com sucesso",
        "Obrigado por se cadastrar no app Wustoki. Agora você já pode chamar o seu motorista e contar com a gente para te levar aonde você quiser. Aproveite!"
    );
    echo json_encode(array("status" => "sucesso"));
}else{
    // Retorna erro se o cadastro falhar
    echo json_encode(array("status" => "erro"));
}
?>