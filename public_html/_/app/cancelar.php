<?php
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/corridas.php");
include_once "../classes/clientes.php";
include("../classes/cancelamentos.php");
include("../classes/mp.php");
include("../classes/transacoes_mp.php");
include_once "../classes/send_mail.php";
include("../classes/transacoes.php");


$crr = new corridas();
$c = new Clientes();
$canc = new cancelamentos();
$mp = new MP();
$t = new transacoes_mp();
$em = new enviaEmail();



$senha = $_POST['senha'];
$telefone = $_POST['telefone'];
//$transacao_id = $_POST['transacao_id'];

$cliente = $c->login($telefone, $senha);

if ($cliente) {
    $cliente_id = $cliente['id'];
    $cidade_id = $cliente['cidade_id'];
    $tc = new transacoes($cidade_id);
    $corrida = $crr->get_all_corridas_cliente($cliente_id)[0];
    $transacao = $t->getByCorridaId($corrida['id']);
    if ($crr->cancelar_corrida($cliente_id)) {
        $canc->inserirCancelamento($corrida['id'], 2, $corrida['motorista_id'], $cliente_id);
        if ($transacao) {
            //se status da transação for approved
            if ($transacao['status'] == "approved") {
                //se status da corrida for 1 ou 0
                if ($corrida['status'] == 1 || $corrida['status'] == 0) {
                    //$payment_id = $transacao['payment_id'];
                    //$mp->reembolsar($payment_id); //vamos adicionar a carteira ao invés de reembolsar
                    $valor = $transacao['valor'];
                    $saldo = $cliente['saldo'];
                    $saldo = str_replace(',', '.', $saldo);
                    $valor = str_replace(',', '.', $valor);
                    $novo_saldo = $saldo + $valor;
                    $novo_saldo = number_format($novo_saldo, 2, ',', '');
                    $c->atualiza_saldo($cliente_id, $novo_saldo);
                    $nome = $cliente['nome'];
                    $email = $cliente['email'];
                    $assunto = "Extorno de Corrida";
                    $mensagem = "Olá, " . $nome . ". A corrida foi cancelada e o valor de R$ " . $valor . " foi estornado para sua carteira de crédito para uso futuro. Agradecemos por utilizar nossos serviços.";
                    $mensagem .= "<br><br>Atenciosamente, Equipe Wustoki.";
                    $mensagem .= "<p>Dúvidas? Entre em contato pelo <a href='https://wa.me/+556285259714'>WhatsApp</a>.</p>";
                    $mensagem .= "<p><img src='https://wustoki.top/_/assets/img/logo_email.jpeg' alt='Logo Wustoki' style='display: block; margin: 20px auto; width: 150px;' /></p>";
                    $mensagem .= "<p style='text-align: center; font-size: 12px; color: #555;'>Wustoki tecnologia Brasil</p>";
                    
                    $em->sendEmail($email, $assunto, $mensagem);
                    $valor_extorno = number_format($valor, 2, ',', '');
                    if (strpos($valor_extorno, ',') === false) {
                        $valor_extorno .= ',00';
                    }
                    $tc->insereTransacao($cliente_id, 'N/A', $valor_extorno, 'EXTORNO CANCELAMENTO', 'CONCLUIDO');
                    
                }
            }
        }
        echo "ok";
    } else {
        echo "erro";
    }
}
