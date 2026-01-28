<?php
//habilita display de erros
include("seguranca.php");
include("../classes/veiculos.php");
include("../classes/motoristas.php");
include("../classes/locacoes.php");
include("../classes/corridas.php");
include("../classes/divisao_locacoes.php");
$dl = new divisao_locacoes();

$v = new veiculos();
$m = new motoristas();
$l = new locacoes();
$c = new corridas();
$lista_veiculos = $v->getAllByCidadeId($_SESSION['cidade_id']);
$lista_motoristas = $m->get_motoristas($_SESSION['cidade_id']);

$divisao = $dl->getByCidadeId($cidade_id);

// Função para pegar as semanas, limitando as últimas 4
function get_last_weeks($limit = 4)
{
    $weeks = [];
    for ($i = 0; $i < $limit; $i++) {
        // Definir início da semana na segunda-feira às 04:00
        $start_of_week = strtotime("last monday 04:00 -$i week");
        // Definir fim da semana na próxima segunda-feira às 03:59
        $end_of_week = strtotime("next monday 03:59 -$i week");

        $weeks[] = [
            'label' => "Semana de " . date('d/m/Y', $start_of_week),
            'start' => date('Y-m-d H:i:s', $start_of_week),
            'end' => date('Y-m-d H:i:s', $end_of_week)
        ];
    }
    return $weeks;
}

// Se não houver POST, pega a última semana por padrão
if (empty($_POST['week'])) {
    $weeks = get_last_weeks();
    $date_from = $weeks[0]['start'];
    $date_to = $weeks[0]['end'];
} else {
    $selected_week = explode('|', $_POST['week']); // Recebe o formato start|end
    $date_from = $selected_week[0];
    $date_to = $selected_week[1];
}



?>

<!doctype html>
<html lang="pt-br">
<?php include "head.php"; ?>
<?php include("menu.php"); ?>

<body>
    <div class="container-principal-produtos">
        <div class="container">
            <br>
            <div class="row">
                <h4 class="page-header">Pesquisar entre:</h4>
                <div class="form-group col-md-8">
                    <form action="relatorio_locacoes.php" method="POST" enctype="multipart/form-data" name="upload">
                        <select name="week" class="form-control">
                            <?php
                            $weeks = get_last_weeks(); // Gera as últimas 4 semanas
                            foreach ($weeks as $week) {
                                $selected = ($week['start'] == $date_from && $week['end'] == $date_to) ? "selected" : "";
                                $start_br = date('d/m/Y H:i:s', strtotime($week['start']));
                                $end_br = date('d/m/Y H:i:s', strtotime($week['end']));
                                echo "<option value='{$week['start']}|{$week['end']}' $selected>{$week['label']} ({$start_br} a {$end_br})</option>";
                            }
                            ?>
                        </select>
                </div>
                <div class="form-group col-md-2">
                    <input type="submit" class="btn btn-primary" name="btn_enviar" value="Pesquisar">
                </div>
                </form>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>Data</th>
                        <th>Motorista</th>
                        <th>Placa</th>
                        <th>Km Inicial</th>
                        <th>Km Final</th>
                        <th>Km Viagem</th>
                        <th>Km Fora</th>
                        <th>Total Fat.</th>
                        <th>Ganhos</th>
                        <th>R$ Locatário</th>
                    </thead>
                    <tbody>
                        <?php
                        $locacoes = $l->getByDatas($_SESSION['cidade_id'], $date_from, $date_to);
                        if ($locacoes) {
                            foreach ($locacoes as $locacao) {
                                $motorista_id = $locacao['motorista_id'];
                                $faturamento = 0;
                                $corridas = $c->get_corridas_motorista_datas($motorista_id, $locacao['data_inicial'], $locacao['data_final']);
                                if ($corridas) {
                                    foreach ($corridas as $corrida) {
                                        $faturamento += str_replace(',', '.', $corrida['taxa']);
                                    }
                                }

                                //ganhos = *25% do faturamento
                                $ganhos = $faturamento * $divisao[0]['franqueado'] / 100; //ganhos do motorista
                                $ganhos_user = $faturamento * $divisao[0]['locatario'] / 100; //ganhos do locatário


                                echo "<tr>";
                                echo "<td>" . date('d/m/Y', strtotime($locacao['data_final'])) . "</td>";
                                echo "<td>" . $locacao['nome'] . "</td>";
                                echo "<td>" . $locacao['placa'] . "</td>";
                                echo "<td>" . $locacao['km_inicial'] . "</td>";
                                echo "<td>" . $locacao['km_final'] . "</td>";
                                echo "<td>" . $locacao['km_viagem'] . "</td>";
                                echo "<td>" . $locacao['km_fora'] . "</td>";
                                echo "<td>R$ " . number_format($faturamento, 2, ',', '.') . "</td>";
                                echo "<td>R$ " . number_format($ganhos, 2, ',', '.') . "</td>";
                                echo "<td>R$ " . number_format($ganhos_user, 2, ',', '.') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Nenhuma locação encontrada</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?php include "dep_query.php"; ?>