<?php
include("seguranca.php");
include("../classes/veiculos.php");
include("../classes/motoristas.php");

$v = new veiculos();
$m = new motoristas();
$lista_veiculos = $v->getAllByCidadeId($_SESSION['cidade_id']);
$lista_motoristas = $m->get_motoristas($_SESSION['cidade_id']);



?>
<!doctype html>
<html lang="pt-br">
<?php include("head.php"); ?>
<style>
    .checklist-item {
        margin-bottom: 10px;
    }

    .detalhes-area {
        background-color: #28a745;
        color: white;
        padding: 10px;
    }
    .checklist{
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
<?php include("menu.php"); ?>


<body>
    <div class="container">
        <div class="container-principal-produtos">
            <hr>
            <div class="row align-items-center mb-3">
                <div class="col-sm-6">
                    <h4 class="page-header">Lista de Veículos</h4>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchVehicle" placeholder="Pesquisar placa...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Placa</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Cor</th>
                                <th scope="col">KM</th>
                                <th scope="col">Motorista</th>
                                <th scope="col">Usuário</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($lista_veiculos) {
                                foreach ($lista_veiculos as $veiculo) {

                                    echo "<tr>";
                                    echo "<td>" . $veiculo['placa'] . "</td>";
                                    echo "<td>" . $veiculo['modelo'] . "</td>";
                                    echo "<td>" . $veiculo['ano'] . "</td>";
                                    echo "<td>" . $veiculo['cor'] . "</td>";
                                    echo "<td>" . $veiculo['km'] . "</td>";

                                    if ($veiculo['status'] == 0) {
                                        echo "<td><span class='badge bg-warning'>Analise</span></td>";
                                    } else {
                                        echo "<td>" . ($veiculo['em_uso'] == 1 ? $veiculo['motorista_nome'] : "Disponível") . "</td>";
                                    }
                                    echo "<td>" . $veiculo['cliente_nome'] . "</td>";

                                    if ($veiculo['status'] == 0) {
                                        echo "<td><span class='badge bg-danger'>Bloqueado</span></td>";
                                    } else {
                                        echo "<td><span class='badge " . ($veiculo['em_uso'] == 1 ? "bg-warning" : "bg-success") . "'>" . ($veiculo['em_uso'] == 1 ? "Em uso" : "Disponível") . "</span></td>";
                                    }
                                    echo "<td><a href='#' data-toggle='modal' data-target='#" . $veiculo['id'] . "' data-id='" . $veiculo['id'] . "' class='btn btn-primary btn-sm'>Editar</a>&nbsp;";
                                    // modal nova locação
                                    if ($veiculo['em_uso'] == 0 && $veiculo['status'] == 1) {
                                        echo "<a href='#' data-toggle='modal' data-target='#loc_" . $veiculo['id'] . "' data-id='" . $veiculo['id'] . "' class='btn btn-success btn-sm'>Nova Locação</a>";
                                    }
                                    //finalizar locação (abre modal)
                                    if ($veiculo['em_uso'] == 1 && $veiculo['status'] == 1) {
                                        echo "<a href='#' data-toggle='modal' data-target='#finalizar_" . $veiculo['id'] . "' data-id='" . $veiculo['id'] . "' class='btn btn-danger btn-sm'>Finalizar Locação</a>";
                                    }

                                    if ($veiculo['status'] == 0) {
                                        echo "&nbsp<a href='ativar_veiculo.php?id=" . $veiculo['id'] . "' class='btn btn-success btn-sm'>Liberar</a>";
                                    } else {
                                        echo "&nbsp<a href='bloquear_veiculo.php?id=" . $veiculo['id'] . "' class='btn btn-danger btn-sm'>Bloquear</a>";
                                    }
                                    // botão abre checlist
                                    echo "&nbsp<a href='#' onclick='abrirChecklistVeiculo(" . $veiculo['id'] . ")' class='btn btn-info btn-sm'>Checklist</a>";
                                    if ($veiculo['img_frente'] != "") {
                                        echo "&nbsp<a href='fotos_veiculo.php?id=" . $veiculo['id'] . "' class='btn btn-info btn-sm'><i class='bi bi-camera'></i></a>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>Nenhum veículo cadastrado</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table -->
            <!-- modal editar -->
            <?php foreach ($lista_veiculos as $veiculo) { ?>
                <div class="modal fade editarVeiculoModal" id="<?php echo $veiculo['id']; ?>" tabindex="-1" aria-labelledby="editarVeiculoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarVeiculoModalLabel">Editar Veículo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body text-left">
                                <form id="formEditarVeiculo" action="editar_veiculo.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $veiculo['id']; ?>">
                                    <div class="mb-3">
                                        <label for="placa" class="form-label">Placa</label>
                                        <input type="text" class="form-control" id="placa" name="placa" value="<?php echo $veiculo['placa']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="modelo" class="form-label">Modelo</label>
                                        <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $veiculo['modelo']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="marca" class="form-label">Marca</label>
                                        <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $veiculo['marca']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ano" class="form-label">Ano</label>
                                        <input type="text" class="form-control" id="ano" name="ano" value="<?php echo $veiculo['ano']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="cor" class="form-label">Cor</label>
                                        <input type="text" class="form-control" id="cor" name="cor" value="<?php echo $veiculo['cor']; ?>">
                                    </div>
                                    <!-- km atual -->
                                    <div class="mb-3">
                                        <label for="km" class="form-label">KM Atual</label>
                                        <input type="text" class="form-control" id="km" name="km_atual" value="<?php echo $veiculo['km_atual']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoria" class="form-label">Categoria</label>
                                        <select class="form-control" id="categoria" name="categoria">
                                            <option value="Carro" <?php echo ($veiculo['categoria'] == 'Carro') ? 'selected' : ''; ?>>Carro</option>
                                            <option value="Moto" <?php echo ($veiculo['categoria'] == 'Moto') ? 'selected' : ''; ?>>Moto</option>
                                            <option value="Van" <?php echo ($veiculo['categoria'] == 'Van') ? 'selected' : ''; ?>>Van</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tipo_combustivel" class="form-label">Tipo de Combustível</label>
                                        <select class="form-control" id="tipo_combustivel" name="tipo_combustivel">
                                            <option value="Gasolina" <?php echo ($veiculo['tipo_combustivel'] == 'Gasolina') ? 'selected' : ''; ?>>Gasolina</option>
                                            <option value="Flex" <?php echo ($veiculo['tipo_combustivel'] == 'Flex') ? 'selected' : ''; ?>>Flex</option>
                                            <option value="Híbrido" <?php echo ($veiculo['tipo_combustivel'] == 'Híbrido') ? 'selected' : ''; ?>>Híbrido</option>
                                            <option value="Diesel" <?php echo ($veiculo['tipo_combustivel'] == 'Diesel') ? 'selected' : ''; ?>>Diesel</option>
                                            <option value="GNV" <?php echo ($veiculo['tipo_combustivel'] == 'GNV') ? 'selected' : ''; ?>>GNV</option>
                                            <option value="Elétrico" <?php echo ($veiculo['tipo_combustivel'] == 'Elétrico') ? 'selected' : ''; ?>>Elétrico</option>
                                        </select>
                                    </div>
                                    <!-- vencimento -->
                                    <div class="mb-3">
                                        <label for="vencimento" class="form-label">Vencimento do Documento </label>
                                        <input type="date" class="form-control" id="vencimento" name="vencimento" value="<?php echo $veiculo['vencimento']; ?>">
                                    </div>
                                    <!-- imagens -->
                                    <div class="mb-3">
                                        <label for="img_frente" class="form-label">Imagem Frente Veículo</label>
                                        <input type="file" class="form-control" id="img_frente" name="img_frente">
                                    </div>
                                    <div class="mb-3">
                                        <label for="img_traseira" class="form-label">Imagem Traseira Veículo</label>
                                        <input type="file" class="form-control" id="img_traseira" name="img_traseira">
                                    </div>
                                    <div class="mb-3">
                                        <label for="img_lateral_direita" class="form-label">Imagem Lateral Direita Veículo</label>
                                        <input type="file" class="form-control" id="img_lateral_direita" name="img_lateral_direita">
                                    </div>
                                    <div class="mb-3">
                                        <label for="img_lateral_esquerda" class="form-label">Imagem Lateral Esquerda Veículo</label>
                                        <input type="file" class="form-control" id="img_lateral_esquerda" name="img_lateral_esquerda">
                                    </div>
                                    <div class="mb-3">
                                        <label for="img_documento" class="form-label">Imagem Documento Veículo</label>
                                        <input type="file" class="form-control" id="img_documento" name="img_documento">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- modal editar -->
            <!-- modal nova locação com lista de motoristas a selecionar, km inicial -->
            <?php foreach ($lista_veiculos as $veiculo) { ?>
                <div class="modal fade novaLocacaoModal" id="loc_<?php echo $veiculo['id']; ?>" tabindex="-1" aria-labelledby="novaLocacaoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalNovaLocacaoLabel">Nova Locação</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body text-left">
                                <form id="formNovaLocacao" action="nova_locacao.php" method="post">
                                    <input type="hidden" name="veiculo_id" value="<?php echo $veiculo['id']; ?>">
                                    <div class="mb-3">
                                        <label for="motorista_id" class="form-label text-left">Motorista</label>
                                        <select class="form-control" id="motorista_id" name="motorista_id">
                                            <?php
                                            foreach ($lista_motoristas as $motorista) {
                                                echo "<option value='" . $motorista['id'] . "'>" . $motorista['nome'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="km_inicial" class="form-label">KM Inicial</label>
                                        <input type="text" class="form-control" id="km_inicial" name="km_inicial" value="<?php echo $veiculo['km_atual']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- modal nova locação -->
            <!-- modal finalizar locação com km_final,  -->
            <?php foreach ($lista_veiculos as $veiculo) { ?>
                <div class="modal fade finalizarLocacaoModal" id="finalizar_<?php echo $veiculo['id']; ?>" tabindex="-1" aria-labelledby="finalizarLocacaoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalFinalizarLocacaoLabel">Finalizar Locação</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body text-left">
                                <form id="formFinalizarLocacao" action="finalizar_locacao.php" method="post">
                                    <input type="hidden" name="veiculo_id" value="<?php echo $veiculo['id']; ?>">
                                    <div class="mb-3">
                                        <label for="km_final" class="form-label">KM Final</label>
                                        <input type="text" class="form-control" id="km_final" name="km_final" value="<?php echo $veiculo['km_atual']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Finalizar Locação</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- modal finalizar locação -->
            <!-- Modal do Checklist -->
            <div class="modal fade" id="checklistModal" tabindex="-1" aria-labelledby="checklistModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content checklist">
                        <div class="modal-header">
                            <h5 class="modal-title" id="checklistModalLabel">Checklist</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="insere_checklist.php" method="POST" id="formChecklist">
                                <input type="hidden" name="veiculo_id" id="veiculo_id" value="">

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pintura_ok" id="pintura_ok" value="1">
                                        <label class="form-check-label" for="pintura_ok">
                                            Pintura – Verificar riscos, amassados ou descascados
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="vidros_ok" id="vidros_ok" value="1">
                                        <label class="form-check-label" for="vidros_ok">
                                            Para-brisa e Vidros – Conferir trincas ou rachaduras
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="retrovisores_ok" id="retrovisores_ok" value="1">
                                        <label class="form-check-label" for="retrovisores_ok">
                                            Retrovisores – Avaliar se estão intactos e ajustáveis
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pneus_ok" id="pneus_ok" value="1">
                                        <label class="form-check-label" for="pneus_ok">
                                            Pneus – Checar desgaste e calibragem
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="estepe_ok" id="estepe_ok" value="1">
                                        <label class="form-check-label" for="estepe_ok">
                                            Estepe – Certificar-se de que está em boas condições
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="macaco_ok" id="macaco_ok" value="1">
                                        <label class="form-check-label" for="macaco_ok">
                                            Macaco – Garantir a presença e funcionamento
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chave_roda_ok" id="chave_roda_ok" value="1">
                                        <label class="form-check-label" for="chave_roda_ok">
                                            Chave de roda – Verificar se está disponível
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="triangulo_ok" id="triangulo_ok" value="1">
                                        <label class="form-check-label" for="triangulo_ok">
                                            Triângulo de sinalização – Conferir presença e estado
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="documentacao_ok" id="documentacao_ok" value="1">
                                        <label class="form-check-label" for="documentacao_ok">
                                            Documentação – CRLV, licenciamento atualizado
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="seguro_ok" id="seguro_ok" value="1">
                                        <label class="form-check-label" for="seguro_ok">
                                            Seguro – Verificar validade e tipo de cobertura
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="limpeza_ok" id="limpeza_ok" value="1">
                                        <label class="form-check-label" for="limpeza_ok">
                                            Limpeza – Inspecionar estado interno e externo
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="combustivel_ok" id="combustivel_ok" value="1">
                                        <label class="form-check-label" for="combustivel_ok">
                                            Combustível – Nível do tanque na retirada e na devolução
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="farois_ok" id="farois_ok" value="1">
                                        <label class="form-check-label" for="farois_ok">
                                            Faróis e lanternas – Conferir funcionamento
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="setas_ok" id="setas_ok" value="1">
                                        <label class="form-check-label" for="setas_ok">
                                            Setas e pisca-alerta – Garantir operação correta
                                        </label>
                                    </div>
                                </div>

                                <div class="checklist-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="buzina_ok" id="buzina_ok" value="1">
                                        <label class="form-check-label" for="buzina_ok">
                                            Buzina – Testar funcionamento
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3 mt-4 detalhes-area">
                                    <label for="detalhes" class="form-label">Descreva detalhes aqui...</label>
                                    <textarea class="form-control" name="detalhes" id="detalhes" rows="5"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('formChecklist').submit();">Salvar Checklist</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include "dep_query.php"; ?>

</html>

<script>
    //pesquisa pela placa
    $("#searchVehicle").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    function abrirChecklistVeiculo(veiculo_id) {
        document.getElementById('veiculo_id').value = veiculo_id;
        //busca os dados do checklist do veiculo se existir
        $.ajax({
            url: 'get_checklist_veiculo.php',
            type: 'POST',
            data: {
                veiculo_id: veiculo_id
            },
            success: function(data) {
                var checklist = JSON.parse(data);
                if (checklist) {
                    checklist = checklist[0];
                    document.getElementById('pintura_ok').checked = checklist.pintura_ok == 1 ? true : false;
                    document.getElementById('vidros_ok').checked = checklist.vidros_ok == 1 ? true : false;
                    document.getElementById('retrovisores_ok').checked = checklist.retrovisores_ok == 1 ? true : false;
                    document.getElementById('pneus_ok').checked = checklist.pneus_ok == 1 ? true : false;
                    document.getElementById('estepe_ok').checked = checklist.estepe_ok == 1 ? true : false;
                    document.getElementById('macaco_ok').checked = checklist.macaco_ok == 1 ? true : false;
                    document.getElementById('chave_roda_ok').checked = checklist.chave_roda_ok == 1 ? true : false;
                    document.getElementById('triangulo_ok').checked = checklist.triangulo_ok == 1 ? true : false;
                    document.getElementById('documentacao_ok').checked = checklist.documentacao_ok == 1 ? true : false;
                    document.getElementById('seguro_ok').checked = checklist.seguro_ok == 1 ? true : false;
                    document.getElementById('limpeza_ok').checked = checklist.limpeza_ok == 1 ? true : false;
                    document.getElementById('combustivel_ok').checked = checklist.combustivel_ok == 1 ? true : false;
                    document.getElementById('farois_ok').checked = checklist.farois_ok == 1 ? true : false;
                    document.getElementById('setas_ok').checked = checklist.setas_ok == 1 ? true : false;
                    document.getElementById('buzina_ok').checked = checklist.buzina_ok == 1 ? true : false;
                    document.getElementById('detalhes').value = checklist.detalhes;
                } else {
                    document.getElementById('pintura_ok').checked = false;
                    document.getElementById('vidros_ok').checked = false;
                    document.getElementById('retrovisores_ok').checked = false;
                    document.getElementById('pneus_ok').checked = false;
                    document.getElementById('estepe_ok').checked = false;
                    document.getElementById('macaco_ok').checked = false;
                    document.getElementById('chave_roda_ok').checked = false;
                    document.getElementById('triangulo_ok').checked = false;
                    document.getElementById('documentacao_ok').checked = false;
                    document.getElementById('seguro_ok').checked = false;
                    document.getElementById('limpeza_ok').checked = false;
                    document.getElementById('combustivel_ok').checked = false;
                    document.getElementById('farois_ok').checked = false;
                    document.getElementById('setas_ok').checked = false;
                    document.getElementById('buzina_ok').checked = false;
                    document.getElementById('detalhes').value = "";
                }
            }
        });
        $('#checklistModal').modal('show');
    }
</script>