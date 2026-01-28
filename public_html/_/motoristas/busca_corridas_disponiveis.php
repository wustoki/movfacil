<?php
include("../classes/motoristas.php");
include("../classes/corridas.php");
include("../classes/seguranca.php");
include("../classes/clientes.php");
include("../classes/tempo.php");
include("../classes/categorias.php");
include ("../classes/avaliacoes.php");
include ("../classes/maps.php");
include("../classes/denuncias.php");
$secret_key = $_POST['secret'];

$s = new seguranca();
if ($s->compare_secret($secret_key)) {
	$c = new corridas();
	$t = new tempo();
	$clientes = new clientes();
	$cat = new categorias(); 
	$m = new motoristas();
	$a = new avaliacoes();
	$mps = new maps();
	$denuncias = new denuncias();
	$cidade_id = $_POST['cidade_id'];
	$id_motorista = $_POST['id_motorista'];
	$corridas  = $c->get_corridas_disponiveis($cidade_id);
	$dados_motorista = $m->get_motorista($id_motorista);
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$ids_categorias = $dados_motorista['ids_categorias']; 
	$ids_categorias = json_decode($ids_categorias);
	$cpf_motorista = $dados_motorista['cpf'];

	$corridas_abertas = $c->get_corridas_abertas($id_motorista);
	if($corridas_abertas){ //se tiver corridas abertas substitui a latitude e longitude pela ultima corrida que será a parada inicial da proxima
		foreach ($corridas_abertas as $corrida_aberta) {
			$latitude = $corrida_aberta['lat_fim'];
			$longitude = $corrida_aberta['lng_fim'];
		}
	}

	if ($corridas) {
		foreach ($corridas as $key => $value) {
			$cliente_id = $value['cliente_id'];
			if($cliente_id != 0){
				$denuncias_cliente = $denuncias->detByClienteEMotorista($cliente_id, $id_motorista, 'Usuário');
				if($denuncias_cliente){
					unset($corridas[$key]);
					continue;
				}
			}

			$cpf_cliente = $clientes->get_cliente_id($cliente_id)['cpf'];
			$cpf_cliente = str_replace(".", "", $cpf_cliente);
			$cpf_cliente = str_replace("-", "", $cpf_cliente);

			if($cpf_motorista == $cpf_cliente){
				unset($corridas[$key]);
				continue;
			}

			$id_categoria = $value['categoria_id'];
			if (!in_array($id_categoria, $ids_categorias)) {
				unset($corridas[$key]);
			} else {
				if ($value['cliente_id'] != 0) {
					$nota = $a->get_media_avaliacoes_cliente($value['cliente_id']);
					if ($nota == null) { 
						$nota = 0;
					}
					//duas casas decimais
					$nota = number_format($nota, 2, '.', '');
					$corridas[$key]['nota_cliente'] = $nota;
					$cliente = $clientes->get_cliente_id($value['cliente_id']);
					$corridas[$key]['telefone_cliente'] = $cliente['telefone'];

					//busca corridas do cliente
					$corridas_cliente = $c->getTotalCorridasCliente($value['cliente_id']);
					$corridas[$key]['total_corridas'] = $corridas_cliente;

					$endereco_corrida = $value['endereco_ini_txt'];
					//encode
					$endereco_corrida = urlencode($endereco_corrida);
					$distancia = $mps->get_distance_address($latitude . "," . $longitude, $endereco_corrida);
					$corridas[$key]['distancia_cliente'] = number_format($distancia['km'], 2, '.', '');
					$corridas[$key]['tempo_cliente'] = number_format($distancia['minutos'], 0, '.', '');

					$distancia_viagem = $value['km'] + $distancia['km'];
					$valor_por_km = str_replace(",", ".", $value['taxa']) / $distancia_viagem;
					$valor_por_km = number_format($valor_por_km, 2, '.', '');
					$corridas[$key]['valor_por_km'] = $valor_por_km;
				}
				$corridas[$key]['hora'] = $t->data_mysql_para_user($value['date']) . " às " . $t->hora_mysql_para_user($value['date']);
				$corridas[$key]['categoria'] = $cat->get_categoria($value['categoria_id'])[0]['nome'];
			}
		}
		//reorganiza indices
		$corridas = array_values($corridas);
		if(count($corridas) == 0){
			echo "no";
			exit;
		}
		echo json_encode($corridas);
		
		//var_dump($ids_categorias);
	} else {
		echo "no";
	}
}
