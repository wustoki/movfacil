<!DOCTYPE html>
<!doctype html>
<html lang="pt-br">
<?php include("head.php"); ?>
<?php
//verifica se tem o cookie de telefone e senha
if (!isset($_COOKIE['telefone']) && !isset($_COOKIE['senha'])) {
    //volta para veiculos.php
    echo "<script>alert('Você não está logado!');</script>";
    echo "<script>location.href = 'veiculos.php';</script>";
} else {
    //se ja tem os cookies, seta as variaveis
    $telefone = $_COOKIE['telefone'];
    $senha = $_COOKIE['senha'];
    include("../classes/clientes.php");
    include("../classes/veiculos.php");
    include("../classes/motoristas.php");
    include("../classes/locacoes.php");
    include("../classes/corridas.php");
    include("../classes/divisao_locacoes.php");
    $dl = new divisao_locacoes();
    $c = new clientes();
    $v = new veiculos();
    $m = new motoristas();
    $l = new locacoes();
    $corr = new corridas();
    $cliente = $c->login($telefone, $senha);
    $cidade_id = $cliente['cidade_id'];
    if (!$cliente) {
        echo "<script>alert('Usuário ou senha inválidos!');</script>";
        echo "<script>location.href = 'https://wustoki.top/';</script>";
    }
}
$veiculo_id = $_GET['veiculo_id'];
$comissao_fixa = $dl ->getByCidadeId($cidade_id)[0]['locatario']; //pega a comissao fixa do franqueado

$comissao_hoje = 0;
$comissao_dessa_semana = 0;
$comissao_desse_mes = 0;
$comissao_desse_ano = 0;
$km_hoje = 0;
$km_dessa_semana = 0;
$km_desse_mes = 0;
$km_desse_ano = 0;

$hoje = date('Y-m-d 23:59:59', strtotime('today'));
$dessa_semana = date('Y-m-d', strtotime('monday this week'));
$desse_mes = date('Y-m-d', strtotime('first day of this month'));
$desse_ano = date('Y-m-d', strtotime('first day of January this year'));

$locacoes_hoje = $l->getByDatasVeiculoId($veiculo_id, date('Y-m-d 00:00:00'), $hoje);

foreach ($locacoes_hoje as $locacao) {
    $motorista_id = $locacao['motorista_id'];
    $corridas = $corr->get_corridas_motorista_datas($motorista_id, $locacao['data_inicial'], $locacao['data_final']);
    foreach ($corridas as $corrida) {
        $taxa = str_replace(',', '.', $corrida['taxa']); // Convert string to float
        $comissao_hoje += (float)$taxa * ($comissao_fixa / 100);
    }
    $km_hoje += $locacao['km_fora'] + $locacao['km_viagem'];
}
$locacoes_dessa_semana = $l->getByDatasVeiculoId($veiculo_id, $dessa_semana, $hoje);
foreach ($locacoes_dessa_semana as $locacao) {
    $motorista_id = $locacao['motorista_id'];
    $corridas = $corr->get_corridas_motorista_datas($motorista_id, $locacao['data_inicial'], $locacao['data_final']);
    foreach ($corridas as $corrida) {
        $taxa = str_replace(',', '.', $corrida['taxa']); // Convert string to float
        $comissao_dessa_semana += (float)$taxa * ($comissao_fixa / 100);
    }
    $km_dessa_semana += $locacao['km_fora'] + $locacao['km_viagem'];
}
$locacoes_desse_mes = $l->getByDatasVeiculoId($veiculo_id, $desse_mes, $hoje);
foreach ($locacoes_desse_mes as $locacao) {
    $motorista_id = $locacao['motorista_id'];
    $corridas = $corr->get_corridas_motorista_datas($motorista_id, $locacao['data_inicial'], $locacao['data_final']);
    foreach ($corridas as $corrida) {
        $taxa = str_replace(',', '.', $corrida['taxa']); // Convert string to float
        $comissao_desse_mes += (float)$taxa * ($comissao_fixa / 100);
    }
    $km_desse_mes += $locacao['km_fora'] + $locacao['km_viagem'];
}
$locacoes_desse_ano = $l->getByDatasVeiculoId($veiculo_id, $desse_ano, $hoje);
foreach ($locacoes_desse_ano as $locacao) {
    $motorista_id = $locacao['motorista_id'];
    $corridas = $corr->get_corridas_motorista_datas($motorista_id, $locacao['data_inicial'], $locacao['data_final']);
    foreach ($corridas as $corrida) {
        $taxa = str_replace(',', '.', $corrida['taxa']); // Convert string to float
        $comissao_desse_ano += (float)$taxa * ($comissao_fixa / 100);
    }
    $km_desse_ano += $locacao['km_fora'] + $locacao['km_viagem'];
}


$dados_veiculo = $v->getById($veiculo_id); //pega os dados do veiculo
//exibe os dados em 4 cards um em cima do outro

?>

<body class="bg-light">
    <div id="cabecalho_msg" class="classe_da_tela" style="height: 50px; width: 100%; background-color: #000; display: flex; align-items: center; justify-content: center;">
        <div id="tela_icon_cabecalho" class="classe_da_tela" style=" height: auto; width: 25%; display: flex; align-items: center; justify-content: center;">
            <i id="voltar_btn" class="bi bi-arrow-left" style="font-size:24px; color: #ffffff;"></i>
        </div>
        <div id="txt_cabecalho" class="classe_da_tela" style=" height: auto; width: 75%;">
            <span class="meu_texto" id="lbl_tela" style="font-size: 18px; color: #ffffff; font-weight: bold; ">Relatório de Locações</span>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="text-center mb-4">
                    <h5 class="mb-2" style="font-size: 18px; font-weight: bold;">Veículo: <?php echo $dados_veiculo['modelo']; ?></h5>
                    <h5 style="font-size: 16px; color: #555;">Placa: <?php echo $dados_veiculo['placa']; ?></h5>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">Comissão Hoje</div>
                            <div class="card-body">
                                <h5 class="card-title">R$ <?php echo number_format($comissao_hoje, 2, ',', '.'); ?></h5>
                                <p class="card-text">Total de locações: <?php echo count($locacoes_hoje); ?></p>
                                <p class="card-text">Km rodados: <?php echo number_format($km_hoje, 0, '', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">Comissão Essa Semana</div>
                            <div class="card-body">
                                <h5 class="card-title">R$ <?php echo number_format($comissao_dessa_semana, 2, ',', '.'); ?></h5>
                                <p class="card-text">Total de locações: <?php echo count($locacoes_dessa_semana); ?></p>
                                <p class="card-text">Km rodados: <?php echo number_format($km_dessa_semana, 0, '', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Comissão Esse Mês</div>
                            <div class="card-body">
                                <h5 class="card-title">R$ <?php echo number_format($comissao_desse_mes, 2, ',', '.'); ?></h5>
                                <p class="card-text">Total de locações: <?php echo count($locacoes_desse_mes); ?></p>
                                <p class="card-text">Km rodados: <?php echo number_format($km_desse_mes, 0, '', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">Comissão Esse Ano</div>
                            <div class="card-body">
                                <h5 class="card-title">R$ <?php echo number_format($comissao_desse_ano, 2, ',', '.'); ?></h5>
                                <p class="card-text">Total de locações: <?php echo count($locacoes_desse_ano); ?></p>
                                <p class="card-text">Km rodados: <?php echo number_format($km_desse_ano, 0, '', '.'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#voltar_btn').click(function() {
                window.location.href = 'veiculos.php';
            });
        });
    </script>