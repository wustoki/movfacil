<?php
include("../classes/motoristas.php");
include("../classes/seguranca.php");
include("../classes/avaliacoes.php");
include("../classes/cancelamentos.php");
include("../classes/corridas.php");
include("../classes/denuncias.php");
include_once "../classes/dados_bancarios.php";
$secret_key = $_POST['secret'];
$s = new seguranca();
$a = new avaliacoes();
$canc = new cancelamentos();
$c = new corridas();
$d = new denuncias();
$db = new dados_bancarios();

if ($s->compare_secret($secret_key)) {

	$cpf = $_POST['cpf'];
	$senha = $_POST['senha'];
	$m = new Motoristas();
	$login = $m->login_motorista($cpf, $senha);
	if ($login) {
		$id = $login['id'];
		$total_denuncias = $d->getTotalDenunciasMotorista($id);
		$total_denuncias_3_meses = $d->getTotalDenunciasMotorista3Meses($id);
		$total_denuncias_um_ano = $d->getTotalDenunciasMotorista1Ano($id);
		if ($total_denuncias_3_meses >= 3 || $total_denuncias_um_ano >= 6) {
			echo "Motorista bloqueado por denúncias, entre em contato com a central";
			exit;
		}
		$dados_bancarios = $db->getByMotoristaId($id);
		if ($m->verifica_se_esta_ativo($id)) {


			$corridas = $c->getCorridasSemana($id);
			$valor_corridas = 0;
			foreach ($corridas as $corrida) {
				if ($corrida['f_pagamento'] == "Pix" || $corrida['f_pagamento'] == "Carteira Crédito") {
					$valor_corridas += str_replace(',', '.', $corrida['taxa']);
				}
			}

			$limite_credito = $login['limite_credito'];
			$saldo = $login['saldo'];
			$saldo = str_replace(',', '.', $saldo);

			$valor_corridas = $valor_corridas + $saldo;

			if($saldo < 0){
				$limite_credito = $limite_credito + $valor_corridas;
			}
			//sobrepoem no array
			$login['limite_credito'] = $limite_credito;

			$media = $a->get_media_avaliacoes($id);
			//duas casas decimais
			$media = number_format($media, 2, '.', '');
			$categoria = $a->getNivelMotorista($media);
			$total_corridas = $c->getTotalCorridasMotorista($id);
			$cancelamentos = $canc->getTaxaCancelamentoMotorista($id);
			$login['url_img'] = "https://wustoki.top/_/admin/uploads/" . $login['img'];
			$login['media'] = $media;
			$login['categoria'] = $categoria;
			$login['desempenho'] = $cancelamentos;
			$login['total_corridas'] = $total_corridas;
			$login['total_denuncias'] = $total_denuncias;
			$login['tipo_chave'] = $dados_bancarios['tipo_chave'];
			$login['nome_banco'] = $dados_bancarios['nome_banco'];
			$login['beneficiario'] = $dados_bancarios['beneficiario'];
			$login['chave_pix'] = $dados_bancarios['chave_pix'];
			echo json_encode($login);
		} else {
			echo "Motorista bloqueado, entre em contato com a central";
		}
	} else {
		echo "Usuario ou senha incorretos";
	}
} else {
	echo "Falha na autenticação, verifique a secret em bd/conexao.php";
}
