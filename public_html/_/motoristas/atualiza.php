<?php
include("../classes/corridas.php");
include("../classes/seguranca.php");
include("../classes/status_historico.php");
include("../classes/motoristas.php");
include("../classes/transacoes_motoristas.php");
include("../classes/transacoes.php");
include("../classes/clientes.php");
include("../classes/corridas_a_avaliar.php");
include("../classes/cancelamentos.php");
include_once "../classes/send_mail.php";
$secret_key = $_POST['secret'];

$s = new seguranca();
if ($s->compare_secret($secret_key)) {
	$id_cidade = $_POST['id_cidade'];
	$c = new corridas();
	$sh = new status_historico();
	$m = new Motoristas();
	$tm = new transacoes_motoristas($id_cidade);
	$tc = new transacoes($id_cidade);
	$cl = new Clientes();
	$caa = new corridas_a_avaliar();
	$canc = new cancelamentos();
	$mail = new enviaEmail();
	$id_corrida = $_POST['id_corrida'];
	$status = $_POST['status'];
	$c->set_status($id_corrida, $status);
	$status_string = $c->status_string($status);
	$sh->salva_status($id_corrida, $status_string, "App Motorista");
	//DESCONTA TAXA DO MOTORISTA
	if ($status == '4' || $status == 4) {
		$dados_corrida = $c->get_corrida_id($id_corrida);
		$id_motorista = $dados_corrida['motorista_id'];
		$dados_motorista = $m->get_motorista($id_motorista);
		$saldo_motorista = $dados_motorista['saldo'];
		$saldo_motorista = str_replace(',', '.', $saldo_motorista);
		$taxa_motorista = $dados_motorista['taxa'];
		$taxa_motorista = str_replace(',', '.', $taxa_motorista);
		$valor_corrida = $dados_corrida['taxa'];
		$valor_corrida = str_replace(',', '.', $valor_corrida);
		$taxa_motorista = $taxa_motorista * $valor_corrida / 100;

		$cliente_id = $dados_corrida['cliente_id'];
		$caa->inserir($cliente_id, $id_corrida);

		$canc->inserirCancelamento($id_corrida, 1, $id_motorista, $cliente_id, 'S');
		//insere tbm cliente
		$canc->inserirCancelamento($id_corrida, 2, $id_motorista, $cliente_id, 'S');

		$corridas_semana = $c->getCorridasSemana($id_motorista);
		//se for a primeira corrida, debita a taxa semanal do saldo do motorista
		if (count($corridas_semana) == 1) {
			$taxa_semanal = str_replace(',', '.', $dados_motorista['taxa_semanal']);
			$novo_saldo = $saldo_motorista - $taxa_semanal;
			$novo_saldo = number_format($novo_saldo, 2, ',', '');
			$m->atualiza_saldo($id_motorista, $novo_saldo);
			$taxa_semanal = number_format($taxa_semanal, 2, ',', '');
			$tm->insereTransacao($id_motorista, 'N/A', $taxa_semanal, 'DEBITO TAXA SEMANAL', 'CONCLUIDO');
			$saldo_motorista = $novo_saldo;
		}

		//desconta taxa do cliente se f_pagamento = "Carteira Crédito"
		$f_pagamento = $dados_corrida['f_pagamento'];
		$id_cliente = $dados_corrida['cliente_id'];
		$dados_cliente = $cl->get_cliente_id($id_cliente); 
		if ($f_pagamento == "Carteira Crédito") {
			$saldo_cliente = $dados_cliente['saldo'];
			$saldo_cliente = str_replace(',', '.', $saldo_cliente);
			$novo_saldo = $saldo_cliente - $valor_corrida;
			$novo_saldo = number_format($novo_saldo, 2, ',', '');
			$cl->atualiza_saldo($id_cliente, $novo_saldo);
			$tc->insereTransacao($id_cliente, 'N/A', $valor_corrida, 'DEBITO CORRIDA', 'CONCLUIDO');
			//passa o valor da corrida para o motorista - a taxa
			//$novo_saldo = $saldo_motorista + ($valor_corrida - $taxa_motorista);
			$novo_saldo = $saldo_motorista - $taxa_motorista;
			$novo_saldo = number_format($novo_saldo, 2, ',', '');
			$m->atualiza_saldo($id_motorista, $novo_saldo);
			$valor_corrida = number_format($valor_corrida, 2, ',', '');
			//$tm->insereTransacao($id_motorista, 'N/A', $valor_corrida, 'CREDITO CORRIDA', 'CONCLUIDO');
			$taxa_motorista = number_format($taxa_motorista, 2, ',', '');
			$tm->insereTransacao($id_motorista, 'N/A', $taxa_motorista, 'DEBITO CORRIDA', 'CONCLUIDO');
			}else if($f_pagamento == "Pix") { // se for pix só adiciona o valor para o motorista menos a taxa
			//$novo_saldo = $saldo_motorista + ($valor_corrida - $taxa_motorista);
			$novo_saldo = $saldo_motorista - $taxa_motorista;
			$novo_saldo = number_format($novo_saldo, 2, ',', '');
			$m->atualiza_saldo($id_motorista, $novo_saldo);
			$valor_corrida = number_format($valor_corrida, 2, ',', '');
			//tm->insereTransacao($id_motorista, 'N/A', $valor_corrida, 'CREDITO CORRIDA', 'CONCLUIDO');
			$taxa_motorista = number_format($taxa_motorista, 2, ',', '');
			$tm->insereTransacao($id_motorista, 'N/A', $taxa_motorista, 'DEBITO CORRIDA', 'CONCLUIDO');
			}else { //caso não seja carteira crédito, desconta a taxa do motorista
			$novo_saldo = $saldo_motorista - $taxa_motorista;
			$novo_saldo = number_format($novo_saldo, 2, ',', '');
			$m->atualiza_saldo($id_motorista, $novo_saldo);
			$taxa_motorista = number_format($taxa_motorista, 2, ',', '');
			$tm->insereTransacao($id_motorista, 'N/A', $taxa_motorista, 'DEBITO CORRIDA', 'CONCLUIDO');
		}

		//envia recibo por email
		$email = $dados_cliente['email'];
		$nome = $dados_cliente['nome'];
		$assunto = "📄 Recibo da Sua Corrida - Wustoki";

		$msg = "Olá " . $nome . ",<br><br>";

		$msg .= "<strong>Recibo da sua corrida:</strong><br><br>";
		$msg .= "<strong>💰 Valor da corrida:</strong> R$ " . $valor_corrida . "<br>";
		$msg .= "<strong>💳 Forma de pagamento:</strong> " . $f_pagamento . "<br>";
		$msg .= "<strong>📍 Endereço de partida:</strong> " . $dados_corrida['endereco_ini_txt'] . "<br>";
		$msg .= "<strong>🏁 Endereço de destino:</strong> " . $dados_corrida['endereco_fim_txt'] . "<br>";
		$msg .= "<strong>🚗 Motorista:</strong> " . $dados_motorista['nome'] . "<br><br>";

		$msg .= "Obrigado por utilizar o <strong>Wustoki</strong>!<br>";
		$msg .= "Estamos à disposição para qualquer dúvida ou suporte.<br><br>";

		$mail->sendEmail($email, $assunto, $msg);
	}
	echo "ok";
}
