<?php
include("../classes/corridas.php");
include("../classes/seguranca.php");
include("../classes/status_historico.php");
include("../classes/motoristas.php");
include("../classes/maps.php");
$secret_key = $_POST['secret'];

$s = new seguranca();
if ($s->compare_secret($secret_key)) {
	$c = new corridas();
	$sh = new status_historico();
	$m = new Motoristas();
	$mps = new maps();
	$id_motorista = $_POST['id_motorista'];
	$id_corrida = $_POST['id_corrida'];
	//verifica se status da corrida é 0
	$corrida = $c->get_corrida_id($id_corrida);
	if ($corrida['status'] != 0) {
		echo "no";
		exit;
	}


	$dados_motorista = $m->get_motorista($id_motorista);
	$nome_motorista = $dados_motorista['nome'];
	$c->altera_motorista($id_corrida, $id_motorista);
	$c->set_status($id_corrida, 1);
	$sh->salva_status($id_corrida, "Motorista " . $nome_motorista . " aceitou a corrida", "App Motorista");

	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	$endereco_corrida = $corrida['endereco_ini_txt'];
	$endereco_corrida = urlencode($endereco_corrida);
	$distancia = $mps->get_distance_address($latitude . "," . $longitude, $endereco_corrida);
	$deslocamento = number_format($distancia['km'], 2, '.', '');

	$c->setDeslocamento($id_corrida, $deslocamento);


	echo "ok";
}
