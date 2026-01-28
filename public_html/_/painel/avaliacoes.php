<?php
include("seguranca.php");
include("../classes/avaliacoes.php");
include("../classes/corridas.php");
include("../classes/clientes.php");
include("../classes/tempo.php");
$a = new avaliacoes();
$crr = new corridas();
$cl = new clientes();
$t = new tempo();
$id = $_GET['id'];
$pessoa = $_GET['pessoa'];
if ($pessoa == 'motorista') {
    $avaliacoes = $a->get_avaliacoes_motorista($id);
} else {
    $avaliacoes = $a->get_avaliacoes_cliente($id);
}
?>
<!doctype html>
<html lang="pt-br">

<?php include "head.php"; ?>
<?php include("menu.php"); ?>

<body>
    <div class="container-fluid">
    </div>
    <div class="container">
        <div class="container-principal-produtos">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="page-header">Avaliações</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th>ID</th>
                            <th>Nota</th>
                            <th>Comentário</th>
                            <th>cliente</th>
                            <th>Data</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($avaliacoes as $linha) {
                                $corrida = $crr->get_corrida_id($linha['corrida_id']);
                                $cliente = $cl->get_cliente_id($linha['cliente_id'])['nome'];
                                $data = $t ->data_mysql_para_user($corrida['date']);
                                $hora = $t ->hora_mysql_para_user($corrida['date']);
                            ?>
                                <tr>
                                    <td><?php echo $linha['id']; ?></td>
                                    <td><?php echo $linha['nota'] . '⭐' ?></td>
                                    <td><?php echo $linha['comentario']; ?></td>
                                    <td><?php echo $cliente; ?></td>
                                    <td><?php echo $data . ' ' . $hora; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php include("dep_query.php"); ?>