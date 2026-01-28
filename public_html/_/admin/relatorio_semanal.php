<?php
//display de errros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("seguranca.php");
include("../bd/config.php");
include "../classes/cidades.php";
include "../classes/franqueados.php";
include "../classes/corridas.php";
include "../classes/acertos_franqueados.php";
include "../classes/dados_bancarios.php";
$p = new corridas();
$c = new cidades();
$f = new franqueados();
$a = new acertos_franqueados();
$bd = new dados_bancarios();

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
                    <form action="relatorio_semanal.php" method="POST" enctype="multipart/form-data" name="upload">
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
                        <th>Franqueado</th>
                        <th>Corridas</th>
                        <th>Saldo a Receber</th>
                        <th>Valor Pago</th>
                        <th>Status</th>
                        <th>Açoes</th>
                        <th>Dados</th>
                    </thead>
                    <tbody>
                        <?php
                        $num = 0;
                        $franqueados = $f->get_usuarios_cidade($cidade_id);
                        foreach ($franqueados as $franqueado) {
                            $corridas = $p->get_corridas_cidade_datas($cidade_id, $date_from, $date_to, true);
                            $total_corridas = 0;
                            $total_valor = 0;
                            $valor_bruto = 0;
                            $valor_taxa = 0;
                            $valor_comissao = 0;
                            $valor_pago = 0;
                            $porcentagem_comissao = $franqueado['comissao'];
                            foreach ($corridas as $corrida) {
                                $total_corridas++;
                                $valor_corrida = str_replace(',', '.', $corrida['taxa']);
                                $total_valor += $valor_corrida;
                                $valor_taxa += str_replace(',', '.', $corrida['taxa']);
                            }

                            $valor_bruto = $total_valor;
                            $valor_comissao = ($total_valor * $porcentagem_comissao) / 100;

                            $num++;



                            //se total_pagar for menor ou igual a 0, não exibe
                            if ($total_valor <= 0) {
                                continue;
                            }


                            //verifica o status do acerto
                            $acerto = $a->getByFranqueado($franqueado['id'], $date_from);
                            if ($acerto) {
                                $status = $acerto['status'];
                                $total_pagar = "0,00";
                                $valor_pago = $acerto['valor'];
                            } else {
                                $total_pagar = $valor_comissao;
                                $valor_pago = "0,00";
                                $status = "ABERTO";
                            }
                            $valor_pago = number_format(floatval($valor_pago), 2, ',', '.');
                            $valor_comissao = number_format(floatval($valor_comissao), 2, ',', '.');

                            echo '<tr>';
                            echo  '<td>' . $franqueado['nome'] . '</td>';
                            echo  '<td>' . $total_corridas . '</td>';

                            echo  '<td><span style="color: green;">' . $valor_comissao . '</span></td>';
                            echo  '<td>' . $valor_pago . '</td>';
                            if ($status == "ABERTO") {
                                echo  '<td><span class="badge badge-danger">' . $status . '</span></td>';
                                echo '<td><a href="#" onclick="acertar_franqueado(' . $franqueado['id'] . ', \'' . $date_from . '\', \'' . $valor_comissao . '\', \'' . $valor_comissao . '\')" class="btn btn-primary btn-sm">Pagar</a></td>';
                                echo '<td><a href="#" data-toggle="modal" data-target="#modalDadosBancarios' . $franqueado['id'] . '" class="btn btn-info btn-sm">Dados Bancários</a></td>';
                            } else {
                                echo  '<td><span class="badge badge-success">' . $status . '</span></td>';
                                echo '<td> Pago </td>';
                                echo '<td><a href="#" data-toggle="modal" data-target="#modalDadosBancarios' . $franqueado['id'] . '" class="btn btn-info btn-sm">Dados Bancários</a></td>';
                            }

                            echo '</tr>';
                            // $dados_bancarios = $bd->getByMotoristaId($motorista['id']);
                            // modal dados bancarios
                            echo '<div class="modal fade" id="modalDadosBancarios' . $franqueado['id'] . '" tabindex="-1" role="dialog" aria-labelledby="modalDadosBancarios' . $franqueado['id'] . '" aria-hidden="true">';
                            echo '<div class="modal-dialog" role="document">';
                            echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                            echo '<h5 class="modal-title" id="modalDadosBancarios' . $franqueado['id'] . '">Dados Bancários</h5>';
                            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                            echo '</div>';
                            echo '<div class="modal-body">';
                            echo '<p><strong>Nome</strong> ' . $franqueado['nome'] . '</p>';
                            echo '<p><strong>Beneficiário:</strong> ' . $franqueado['nome'] . '</p>';
                            echo '<p><strong>Chave PIX:</strong> ' . $franqueado['cpf'] . '</p>';
                            echo '<p><strong>Tipo de Chave:</strong> CPF</p>';
                            echo '</div>';
                            echo '<div class="modal-footer">';
                            echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
<?php include("dep_query.php"); ?>

</html>

<script>
    function acertar_franqueado(franqueado_id, semana, total_pagar, valor_bruto) {
        if (confirm("Deseja realmente acertar com o motorista?")) {
            $.ajax({
                type: "POST",
                url: "acertar_franqueado.php",
                data: {
                    franqueado_id: franqueado_id,
                    semana: semana,
                    valor: total_pagar,
                    valor_bruto: valor_bruto
                },
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        }
    }
</script>