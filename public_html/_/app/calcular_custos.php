<?php
header("access-control-allow-origin: *");
include("../bd/config.php");
include("../classes/cidades.php");
include("../classes/categorias.php");
include("../classes/dinamico_mapa.php");
include("../classes/categorias_horarios.php");
include("../classes/compartilhamentos.php");

$dados_retorno = array();

$cidade_id = $_POST['cidade_id'];
// $endereco_ini = $_POST['endereco_ini'];
// $endereco_ini = str_replace(" ", "+", $endereco_ini);

// $endereco_fim = $_POST['endereco_fim'];
// $endereco_fim = str_replace(" ", "+", $endereco_fim);

// $categoria_id = $_POST['categoria_id'];
$lat_ini = $_POST['lat_ini'];
$lng_ini = $_POST['lng_ini'];
$lat_fim = $_POST['lat_fim'];
$lng_fim = $_POST['lng_fim'];

$qnt_usuarios = $_POST['qnt_usuarios'];

$c = new categorias();
$ct = new cidades();
$dm = new dinamico_mapa();
$dh = new dinamico_horarios();
$comp = new compartilhamentos();

$categorias = $c->get_categorias($cidade_id);

$url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . $lat_ini . ',' . $lng_ini . '&destination=' . $lat_fim . ',' . $lng_fim . '&key=' . KEY_GOOGLE_MAPS . '&language=pt-BR&region=BR&mode=driving';
$json = file_get_contents($url);
$obj = json_decode($json);

$km = $obj->routes[0]->legs[0]->distance->value;
$km = $km / 1000;

$minutos = $obj->routes[0]->legs[0]->duration->value;
$minutos = $minutos / 60;
$retorno_fim = array();
foreach ($categorias as $dados_categoria) {

    $taxa_km = $dados_categoria['tx_km'];
    $taxa_km = str_replace(",", ".", $taxa_km);
    $taxa_minuto = $dados_categoria['tx_minuto'];
    $taxa_minuto = str_replace(",", ".", $taxa_minuto);
    $taxa_base = $dados_categoria['tx_base'];
    $taxa_base = str_replace(",", ".", $taxa_base);

    //somando as taxas
    $taxa = ($km * $taxa_km) + ($minutos * $taxa_minuto) + $taxa_base;

    //verifica se está dentro do dinamico de horarios
    $taxa_add = 0;
    $taxa_add_horarios = 0;
    $dinamico_horarios = $dados_categoria['dinamico_horarios'];
    foreach ($dinamico_horarios as $horario) {
        $taxa_h = $dh->verifica_horario($horario);
        if ($taxa_h) {
            $taxa_add = str_replace(",", ".", $taxa_h['adicional']);
            if ($taxa_add > $taxa_add_horarios) {
                $taxa_add_horarios = $taxa_add;
                $dados_retorno['dinamico_horarios'] = $taxa_h;
            }
        }
    }
    //fim verifica se está dentro do dinamico de horarios

    //verifica se está dentro do dinamico de mapa e pega o mais caro
    $taxa_add_mapa_end_ini = 0;
    $taxa_add = 0;
    $dinamico_mapa = $dados_categoria['dinamico_local'];
    foreach ($dinamico_mapa as $din_mapa) {
        $taxa_m = $dm->verifica_localizacao($cidade_id, $lat_ini, $lng_ini);
        if ($taxa_m) {
            $tx_add = str_replace(",", ".", $taxa_m['adicional']);
            if ($tx_add > $taxa_add_mapa_end_ini) {
                $taxa_add_mapa_end_ini = $tx_add;
                $dados_retorno['dinamico_mapa_ini'] = $taxa_m;
            }
        }
    }
    //fim verifica se está dentro do dinamico de mapa

    $taxa_add = 0;
    $taxa_add_mapa_end_fim = 0;
    $dinamico_mapa = $dados_categoria['dinamico_local'];
    foreach ($dinamico_mapa as $din_mapa) {
        $taxa_m = $dm->verifica_localizacao($cidade_id, $lat_fim, $lng_fim);
        if ($taxa_m) {
            $taxa_add = str_replace(",", ".", $taxa_m['adicional']);
            if ($taxa_add > $taxa_add_mapa_end_fim) {
                $taxa_add_mapa_end_fim = $taxa_add;
                $dados_retorno['dinamico_mapa_fim'] = $taxa_m;
            }
        }
    }
    //fim verifica se está dentro do dinamico de mapa



    $taxa += $taxa_add_horarios + $taxa_add_mapa_end_ini + $taxa_add_mapa_end_fim;

    //verifica se está dentro do compartilhamento
    $taxa_add_compartilhamento = 0;
    $compartilhamentos = $dados_categoria['compartilhamentos'];
    foreach ($compartilhamentos as $compa) {
        $dados_comp = $comp->getById($compa);
        if ($dados_comp['qnt_usuarios'] == $qnt_usuarios) {
            $porcentagem_sobre_valor = $dados_comp['porcentagem'];
            $taxa_add_compartilhamento = ($taxa * $porcentagem_sobre_valor) / 100;
        }
    }
    $taxa += $taxa_add_compartilhamento;
    //fim verifica se está dentro do compartilhamento

    //verifica taxa minima
    $taxa_minima = $dados_categoria['tx_minima'];
    $taxa_minima = str_replace(",", ".", $taxa_minima);
    if ($taxa < $taxa_minima) {
        $taxa = $taxa_minima;
    }

    $taxa = number_format($taxa, 2, ',', '.');
    $minutos = number_format($minutos, 0, ',', '.');
    $km = number_format($km, 2, '.', '.');
    $dados_retorno['id'] = $dados_categoria['id'];
    $dados_retorno['nome'] = $dados_categoria['nome'];
    $dados_retorno['descricao'] = $dados_categoria['descricao'];
    $dados_retorno['img'] = $dados_categoria['img'];
    $dados_retorno['taxa'] = $taxa;
    $dados_retorno['ordem'] = $dados_categoria['ordem'];
    $retorno_fim['categorias'][] = $dados_retorno;
}
//ordenando array de categorias pelo campo ordem
$ordem = array();
foreach ($retorno_fim['categorias'] as $key => $row) {
    $ordem[$key] = $row['ordem'];
}
array_multisort($ordem, SORT_ASC, $retorno_fim['categorias']);
//fim ordenando array de categorias pelo campo ordem
$retorno_fim['dados']['km'] = $km;
$retorno_fim['dados']['minutos'] = $minutos;
echo json_encode($retorno_fim);
