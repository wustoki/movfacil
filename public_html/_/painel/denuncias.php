<?php
include("seguranca.php");
include("../bd/config.php");
include_once '../classes/corridas.php';
include_once '../classes/motoristas.php';
include_once '../classes/denuncias.php';
include_once '../classes/clientes.php';

$c = new corridas();
$m = new motoristas();
$d = new denuncias();
$cl = new clientes();

$denuncias = $d->getByCidadeId($_SESSION['cidade_id']);
//invertendo a ordem
$denuncias = array_reverse($denuncias);

?>
<!doctype html>
<html lang="pt-br">

<?php include "head.php"; ?>
<?php include("menu.php");
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Denúncias</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Corrida</th>
                            <th>Motivo</th>
                            <th>Origem</th>
                            <th>Descrição</th>
                            <th>Cliente</th>
                            <th>Motorista</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($denuncias as $denuncia) : 
                        $motorista_id = $c->get_corrida_id($denuncia['corrida_id'])['motorista_id'];

                            ?>
                            <tr>
                                <td><?= $denuncia['corrida_id'] ?></td>
                                <td><?= $denuncia['motivo'] ?></td>
                                <td><?= $denuncia['origem'] ?></td>
                                <td><?= substr($denuncia['descricao'], 0, 10) . '...' ?></td>
                                <td><?= $cl->get_cliente_id($denuncia['cliente_id'])['nome'] ?></td>
                                <td><?= $m->get_motorista($motorista_id)['nome'] ?></td>
                                <td>
                                    <!-- modal com detalhes -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal<?= $denuncia['id'] ?>">
                                        Detalhes
                                    </button>
                                    <!-- deletar -->
                                    <a href="deleta_denuncia.php?id=<?= $denuncia['id'] ?>" class="btn btn-danger">Deletar</a>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="modal<?= $denuncia['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal<?= $denuncia['id'] ?>Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal<?= $denuncia['id'] ?>Label">Detalhes da denúncia</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php if ($denuncia['img'] != '') : ?>
                                                <div style="text-align: center;">
                                                    <img src="../admin/uploads/<?= $denuncia['img'] ?>" alt="Imagem da denúncia" style="height: 300px; width: auto;" class="img-fluid">
                                                </div>
                                            <?php endif; ?>
                                            <p><strong>Corrida:</strong> <?= $denuncia['corrida_id'] ?></p>
                                            <p><strong>Motivo:</strong> <?= $denuncia['motivo'] ?></p>
                                            <p><strong>Origem:</strong> <?= $denuncia['origem'] ?></p>
                                            <p><strong>Descrição:</strong> <?= $denuncia['descricao'] ?></p>
                                            <p><strong>Cliente:</strong> <?= $cl->get_cliente_id($denuncia['cliente_id'])['nome'] ?></p>
                                            <p><strong>Motorista:</strong> <?= $m->get_motorista($denuncia['motorista_id'])['nome'] ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<?php include("dep_query.php"); ?>