<?php
include("../classes/motoristas.php");
include("../classes/veiculos.php");
include("../classes/locacoes.php");
include("../classes/corridas.php");

$m = new motoristas();
$v = new veiculos();
$l = new locacoes();
$c = new corridas();


$veiculo_id = $_POST['veiculo_id'];
$km_final = $_POST['km_final'];


$locacao = $l->getByVeiculoId($veiculo_id);

$id_motorista = $locacao[0]['motorista_id'];
$id_locacao = $locacao[0]['locacao_id'];
$km_inicial = $locacao[0]['km_inicial'];



$data_inicial = $locacao[0]['data_inicial'];
$data_final = date('Y-m-d H:i:s');

$corridas = $c->get_corridas_motorista_datas($id_motorista, $data_inicial, $data_final);
//dados a preencher:
$km_viagem = 0;
$km_fora = 0;


if($corridas){
    foreach($corridas as $corrida){
        $km_viagem += $corrida['km'];
        //soma tambem a coluna deslocamento
        $km_viagem += $corrida['deslocamento'];
    }
    $km_fora = $km_final - $km_inicial - $km_viagem; //se houver corridas, o km fora é o total percorrido menos o total de corridas
} else {
    $km_viagem = 0;
    $km_fora = $km_final - $km_inicial; //se não houver corridas, o km fora é o total percorrido
}

$l->setKmFinal($id_locacao, $km_final);
$l->setKmViagem($id_locacao, $km_viagem);
$l->setKmFora($id_locacao, $km_fora);
$l->setDataFinal($id_locacao, $data_final);
//altera o status do veículo para disponível
$l->setStatus($id_locacao, 1);

$v->setKmAtual($veiculo_id, $km_final);

echo "<script>alert('Locação finalizada com sucesso!');</script>";
echo "<script>location.href = 'veiculos.php';</script>";

?>


