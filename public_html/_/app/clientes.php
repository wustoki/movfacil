<?php 
// Define o cabeçalho para permitir requisições de outras origens (PWA)
header('access-control-allow-origin: *');
header('Content-Type: application/json'); // Garante que a resposta seja JSON

// INCLUSÕES DE CLASSES ORIGINAIS
include_once "../classes/clientes.php";
include_once "../classes/avaliacoes.php";
include_once "../classes/cancelamentos.php";
include_once "../classes/corridas.php";
include_once "../classes/send_mail.php";
include_once "../classes/motoristas.php"; // <--- NOVO: CLASSE MOTORISTAS ADICIONADA

$clientes = new Clientes();
$a = new avaliacoes();
$c = new cancelamentos();
$cor = new corridas();
$sm = new enviaEmail();
$m = new Motoristas(); // <--- NOVO: INSTÂNCIA DA CLASSE MOTORISTAS

// NOVO: Tratamento de entrada para suportar JSON (PWA) e POST (App Nativo)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Tenta pegar os dados do JSON; se falhar, tenta pegar do POST original
$telefone = $data['telefone'] ?? $_POST['telefone'] ?? null;
$senha = $data['senha'] ?? $_POST['senha'] ?? null;
$ref_cliente = $data['ref_cliente'] ?? $_POST['ref_cliente'] ?? "";

// VERIFICAÇÃO BÁSICA DE ENTRADA
if (!$telefone || !$senha) {
    echo json_encode(["status" => "erro", "erro" => "Telefone ou senha incompletos."]);
    exit;
}

$salt = "anjdsn5s141d5";
$senha = md5($senha.$salt);

$cliente = $clientes->verifica_se_existe($telefone);

if($cliente){
    if($cliente['senha'] == $senha){
        $cliente_id = $cliente['id'];

        // --- LÓGICA DO APP DRIVER PWA ---
        // 1. Verifica se o cliente possui perfil de motorista ativo
        $motorista = $m->verifica_se_e_motorista($cliente_id); 
        $is_motorista = ($motorista && $motorista['ativo'] == '1'); 
        
        $motorista_id = $is_motorista ? $motorista['id'] : 0;
        $perfil = $is_motorista ? 'motorista' : 'passageiro';
        // --- FIM LÓGICA PWA ---
        
        if($ref_cliente != ""){
            $clientes->setRefCliente($cliente_id, $ref_cliente);
        }
        $performance = $c ->getTaxaCancelamentoCliente($cliente_id);
        //to int
        $performance = intval($performance);
        $n_corridas = $cor->getTotalCorridasCliente($cliente_id);
        $nota = $a->get_media_avaliacoes_cliente($cliente_id);
        if($nota == null){
            $nota = 0;
        }
        //duas casas decimais
        $nota = number_format($nota, 2, '.', '');

        $retorno = array(
            "status" => "sucesso",
            "id" => $cliente['id'],
            "perfil" => $perfil, // <--- NOVO: Perfil do usuário logado
            "motorista_id" => $motorista_id, // <--- NOVO: ID do motorista (se motorista)
            "nome" => $cliente['nome'],
            "telefone" => $cliente['telefone'],
            "ativo" => $cliente['ativo'],
            "saldo" => $cliente['saldo'],
            "cidade_id" => $cliente['cidade_id'],
            "ref_cliente" => $cliente['ref_cliente'],
            "nota" => $nota,
            "performance" => $performance,
            "n_corridas" => $n_corridas
        );

        //se $ref_cliente for diferente de  $cliente['ref_cliente'] envia email
        if($ref_cliente != "" && $ref_cliente != $cliente['ref_cliente']){
            $msg = "Olá ".$cliente['nome'].",<br><br>";
            $msg .= "Detectamos um login em sua conta Wustoki realizado em um novo dispositivo. Caso tenha sido você, não é necessário se preocupar. Aqui estão os detalhes do acesso: <br><br>";
            $msg .= "Data: ".date("d/m/Y H:i:s")."<br>";
            $msg .= "Dispositivo: ".$_SERVER['HTTP_USER_AGENT']."<br>";
            $msg .= "IP: ".$_SERVER['REMOTE_ADDR']."<br><br>";
            $msg .= "Se você reconhece este acesso, pode ignorar este e-mail.  <br><br>";
            $msg .= "<b>⚠️ Não reconhece este login?</b><br><br>";
            $msg .= "1 .Altere sua senha imediatamente em nosso aplicativo. <br>";
            $msg .= "2. Entre em contato com nossa equipe de suporte pelo <a href='https://wa.me/+556285259714'>WhatsApp</a>". "<br><br>";
            $msg .= "A segurança de sua conta é nossa prioridade. Para mais dicas de segurança, acesse nosso site ou fale com nossa equipe.  ,<br>";
            $msg .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";
            $msg .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki Mobilidade</p>";

            $assunto = "Alerta de Segurança: Novo Login Detectado em Outro Dispositivo";
            $sm->sendEmail($cliente['email'], $assunto, $msg);
        }

    } else {
        $retorno = array(
            "status" => "erro",
            "erro" => "Telefone ou senha incorretos"
        );
    }
} else {
    $retorno = array(
        "status" => "erro",
        "erro" => "Telefone ou senha incorretos"
    );
}

echo json_encode($retorno);