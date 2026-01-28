<?php
header('access-control-allow-origin: *');
include_once "../classes/transacoes.php";
include '../classes/configuracoes_pagamento.php';
include_once "../classes/clientes.php";
include_once "../classes/send_mail.php";

class get_pagamento
{
    public $dados;

    public function get()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.pagmp.com/api/verifica_pagamento.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->dados,

        )); 

        $response = curl_exec($curl);
        // echo $response;
        curl_close($curl);
        return $response;
    }
}

$cidade_id = $_POST['cidade_id'];
$t = new transacoes($cidade_id);
$cp = new configuracoes_pagamento();
$p = new get_pagamento();
$c = new Clientes();
$em = new enviaEmail();

$user_id = $_POST['user_id'];

$token = $cp->read_configuracoes_pagamento($cidade_id)['token'];
$transacoes = $t->getByUserId($user_id);

$alterou = false;
foreach($transacoes as $transacao){
    //verifica se status = PENDENTE
    if($transacao['status'] == "PENDENTE"){
        $dados = array(
            'token' => $token,
            'ref' => $transacao['ref']
        );
        $p->dados = $dados;
        $pg = $p->get();
        $pg = json_decode($pg, true);
        $status_pagamento = $pg['status'];
        if ($status_pagamento == "Aprovado" || $status_pagamento == "Autorizado") {
        //if ($transacao['id'] == 37) { //debug
            $t->atualizaStatusId($transacao['id'], "CONCLUIDO");
            $saldo_atual = $c->get_cliente_id($user_id)['saldo'];
            $saldo_atual = str_replace(",", ".", $saldo_atual);
            $saldo_adicional = str_replace(",", ".", $transacao['valor']);
            $saldo_novo = $saldo_atual + $saldo_adicional;
            $saldo_novo = number_format($saldo_novo, 2, '.', '');
            $saldo_novo = str_replace(".", ",", $saldo_novo);
            $c->atualiza_saldo($user_id, $saldo_novo);
            $alterou = true;

            //envia email
            $dados_cliente = $c->get_cliente_id($user_id);
            $nome = $dados_cliente['nome'];
            $email = $dados_cliente['email'];
            $assunto = "Pagamento Aprovado";
            $mensagem = "Olá, " . $nome . ". Seu pagamento foi aprovado! O valor de R$ " . $transacao['valor'] . " foi adicionado ao seu saldo que agora é de R$ " . $saldo_novo . ".";
            $mensagem .= "<br><br>Atenciosamente, Equipe Wustoki.";
            $mensagem .= "<p>Dúvidas? Entre em contato pelo <a href='https://wa.me/+556285259714'>WhatsApp</a>.</p>";
            
            $mensagem .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";
            
            $mensagem .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";
            $em->sendEmail($email, $assunto, $mensagem);
        }
    }
}
if($alterou){
    echo json_encode(array('status' => 'ok'));
}else{
    echo json_encode(array('status' => 'no'));
}
?>