<!DOCTYPE html>
<!doctype html>
<html lang="pt-br">
<?php include("head.php"); ?>
<?php
//verifica se tem o cookie de telefone e senha
if (!isset($_COOKIE['telefone']) && !isset($_COOKIE['senha'])) {
    //verifica se foram passados via post
    if (!isset($_POST['telefone']) && !isset($_POST['senha'])) {
        //cria um form usando o metodo post para enviar os dados pegando o telefone e senha que estão no localStorage do js
        echo "<form method='POST' action='veiculos.php'>";
        echo "<input type='hidden' name='telefone' id='telefone' value=''>";
        echo "<input type='hidden' name='senha' id='senha' value=''>";
        echo "</form>";
        //cria um script para pegar os dados do localStorage e enviar via post
        echo "<script>";
        echo "document.getElementById('telefone').value = localStorage.getItem('telefone_cliente');";
        echo "document.getElementById('senha').value = localStorage.getItem('senha_cliente');";
        echo "document.forms[0].submit();";
        echo "</script>";
    } else {
        //se foram passados via post, seta os cookies
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];
        setcookie("telefone", $_POST['telefone'], time() + (86400 * 30), "/");
        setcookie("senha", $_POST['senha'], time() + (86400 * 30), "/");
        //redireciona para a mesma pagina
        echo "<script>location.href = 'veiculos.php';</script>";
    }
} else {
    //se ja tem os cookies, seta as variaveis
    $telefone = $_COOKIE['telefone'];
    $senha = $_COOKIE['senha'];
    include_once "../classes/clientes.php";
    include_once "../classes/veiculos.php";
    $c = new clientes();
    $v = new veiculos();
    $cliente = $c->login($telefone, $senha);
    if (!$cliente) {
        echo "<script>alert('Usuário ou senha inválidos!');</script>";
        echo "<script>location.href = 'https://wustoki.top/';</script>";
    }
    $veiculos = $v->getByUserId($cliente['id']);
}

?>

<body>
    <div id="cabecalho_msg" class="classe_da_tela" style="height: 50px; width: 100%; background-color: #000; display: flex; align-items: center; justify-content: center;">
        <div id="tela_icon_cabecalho" class="classe_da_tela" style=" height: auto; width: 25%; display: flex; align-items: center; justify-content: center;">
            <i id="voltar_btn" class="bi bi-arrow-left" style="font-size:24px; color: #ffffff;"></i>
        </div>
        <div id="txt_cabecalho" class="classe_da_tela" style=" height: auto; width: 75%;">
            <span class="meu_texto" id="lbl_tela" style="font-size: 18px; color: #ffffff; font-weight: bold; ">Lista de veículos cadastrados</span>
        </div>
    </div>
    <!-- botão cadastrar novo veiculo -->
    <div style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
        <a href="cadastro_veiculo.php" class="btn btn-primary btn-lg rounded-circle">
            <i class="bi bi-plus-circle"></i>
        </a>
    </div>
    <!-- lista de veiculos com botão de ver que vai abrir um modal com os detalhes do veiculo  e deletar que vai abrir um modal de confirmação de exclusão -->
    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Placa</th>
                            <!-- <th scope="col">Marca</th> -->
                            <th scope="col">Status</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($veiculos)) {
                            echo "<tr><td colspan='3' class='text-center'>Nenhum veículo cadastrado ainda</td></tr>";
                        } else {
                            foreach ($veiculos as $veiculo) {
                                echo "<tr>";
                                echo "<td>" . $veiculo['placa'] . "</td>";
                                // echo "<td>" . $veiculo['marca'] . "</td>";
                                echo "<td>";
                                if ($veiculo['status'] == 0) {
                                    echo "<span class='badge badge-danger'>Bloqueado</span>";
                                } elseif ($veiculo['em_uso'] == 1) {
                                    echo "<span class='badge badge-info'>Em uso</span>";
                                } elseif ($veiculo['em_uso'] == 0) {
                                    echo "<span class='badge badge-success'>Disponível</span>";
                                } else {
                                    echo "<span class='badge badge-secondary'>Indisponível</span>";
                                }
                                echo "</td>";
                                echo "<td>";
                                echo "<a href='relatorio.php?veiculo_id=" . $veiculo['id'] . "' class='btn btn-info btn-sm'><i class='bi bi-bar-chart'></i></a> ";
                                echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modal_detalhes_veiculo_" . $veiculo['id'] . "'><i class='bi bi-eye'></i></button> ";
                                echo "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modal_editar_veiculo_" . $veiculo['id'] . "'><i class='bi bi-pencil'></i></button> ";
                                //mostra o status do veiculo se estiver em uso
                                
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- modal de detalhes do veiculo -->
    <?php foreach ($veiculos as $veiculo): ?>
        <div class="modal fade" id="modal_detalhes_veiculo_<?php echo $veiculo['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal_detalhes_veiculo_<?php echo $veiculo['id']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalhes do veículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div id="detalhes_veiculo_<?php echo $veiculo['id']; ?>">
                            <p>Placa: <span><?php echo $veiculo['placa']; ?></span></p>
                            <p>Modelo: <span><?php echo $veiculo['modelo']; ?></span></p>
                            <p>Marca: <span><?php echo $veiculo['marca']; ?></span></p>
                            <p>Ano: <span><?php echo $veiculo['ano']; ?></span></p>
                            <p>Cor: <span><?php echo $veiculo['cor']; ?></span></p>
                            <p>Categoria: <span><?php echo $veiculo['categoria']; ?></span></p>
                            <p>Tipo de combustível: <span><?php echo $veiculo['tipo_combustivel']; ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- modal de confirmação de exclusão -->
    <div class="modal fade" id="modal_confirmacao_exclusao" tabindex="-1" role="dialog" aria-labelledby="modal_confirmacao_exclusao" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_confirmacao_exclusao">Confirmação de exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body
                text-center">
                    <p>Deseja realmente excluir este veículo?</p>
                    <button type="button" class="btn btn-danger" onclick="excluirVeiculo()">Sim</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal editar veiculo -->
    <?php foreach ($veiculos as $veiculo): ?>
        <div class="modal fade" id="modal_editar_veiculo_<?php echo $veiculo['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal_editar_veiculo_<?php echo $veiculo['id']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar veículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="editar_veiculo.php">
                            <input type="hidden" name="id" value="<?php echo $veiculo['id']; ?>">
                            <input type="hidden" name="telefone" value="<?php echo $_COOKIE['telefone']; ?>">
                            <input type="hidden" name="senha" value="<?php echo $_COOKIE['senha']; ?>">

                            <div class="form-row mt-3">
                                <div class="form-group col-md-6">
                                    <label for="placa">Placa</label>
                                    <input type="text" class="form-control" id="placa" name="placa" value="<?php echo $veiculo['placa']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" placeholder="Ex: Onix, HB20, etc" name="modelo" value="<?php echo $veiculo['modelo']; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="marca">Marca</label>
                                    <input type="text" class="form-control" placeholder="Ex: Chevrolet, Hyundai, etc." id="marca" name="marca" value="<?php echo $veiculo['marca']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ano">Ano</label>
                                    <input type="text" class="form-control" placeholder="Ex: 2024" id="ano" name="ano" value="<?php echo $veiculo['ano']; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cor">Cor</label>
                                    <input type="text" class="form-control" id="cor" placeholder="Ex: Branco" name="cor" value="<?php echo $veiculo['cor']; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="categoria">Categoria</label>
                                    <select id="categoria" name="categoria" class="form-control" required>
                                        <option value="Carro" <?php if ($veiculo['categoria'] == 'Carro') echo 'selected'; ?>>Carro</option>
                                        <option value="Moto" <?php if ($veiculo['categoria'] == 'Moto') echo 'selected'; ?>>Moto</option>
                                        <option value="Van" <?php if ($veiculo['categoria'] == 'Van') echo 'selected'; ?>>Van</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tipo_combustivel">Tipo de Combustível</label>
                                    <select id="tipo_combustivel" name="tipo_combustivel" class="form-control" required>
                                        <option value="Gasolina" <?php if ($veiculo['tipo_combustivel'] == 'Gasolina') echo 'selected'; ?>>Gasolina</option>
                                        <option value="Flex" <?php if ($veiculo['tipo_combustivel'] == 'Flex') echo 'selected'; ?>>Flex</option>
                                        <option value="Híbrido" <?php if ($veiculo['tipo_combustivel'] == 'Híbrido') echo 'selected'; ?>>Híbrido</option>
                                        <option value="Diesel" <?php if ($veiculo['tipo_combustivel'] == 'Diesel') echo 'selected'; ?>>Diesel</option>
                                        <option value="GNV" <?php if ($veiculo['tipo_combustivel'] == 'GNV') echo 'selected'; ?>>GNV</option>
                                        <option value="Elétrico" <?php if ($veiculo['tipo_combustivel'] == 'Elétrico') echo 'selected'; ?>>Elétrico</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


    <?php include("dep_query.php"); ?>

    <script>
        var id_selected = 0;

        function detalhesVeiculo(id) {
            fetch('detalhes_veiculo.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('placa_veiculo').innerText = data.placa;
                    document.getElementById('modelo_veiculo').innerText = data.modelo;
                    document.getElementById('marca_veiculo').innerText = data.marca;
                    document.getElementById('ano_veiculo').innerText = data.ano;
                    document.getElementById('cor_veiculo').innerText = data.cor;
                    document.getElementById('categoria_veiculo').innerText = data.categoria;
                    document.getElementById('tipo_combustivel_veiculo').innerText = data.tipo_combustivel;
                });
        }

        function setVeiculoId(id) {
            id_selected = id;
        }

        function excluirVeiculo() {
            let id = id_selected;
            let telefone = localStorage.getItem('telefone_cliente');
            let senha = localStorage.getItem('senha_cliente');

            let formData = new FormData();
            formData.append('id', id);
            formData.append('telefone', telefone);
            formData.append('senha', senha);

            fetch('excluir_veiculo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Veículo excluído com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Erro ao excluir veículo!'
                        });
                    }
                });
        }

        //voltar para a tela anterior
        document.getElementById('voltar_btn').addEventListener('click', () => {
            window.location.href = 'https://wustoki.top/';
        });
    </script>
</body>