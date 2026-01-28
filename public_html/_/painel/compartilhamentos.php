<?
include("seguranca.php");
include "../classes/compartilhamentos.php";


$c = new compartilhamentos();
if(isset($_POST['btn_enviar'])){
    $nome = $_POST['nome'];
    $qnt_usuarios = $_POST['qnt_usuarios'];
    $porcentagem = $_POST['porcentagem'];
    $c->cadastra($nome, $cidade_id, $qnt_usuarios, $porcentagem);
}
// editar
if(isset($_POST['btn_editar'])){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $qnt_usuarios = $_POST['qnt_usuarios'];
    $porcentagem = $_POST['porcentagem'];
    $c->edita($id, $nome, $cidade_id, $qnt_usuarios, $porcentagem);
}
?>
<!doctype html>
<html lang="pt-br">
<?php include "head.php"; ?>
<?php include("menu.php");
?>

<body>
    <div class="container-fluid">
        <div class="container">
            <div class="container-principal-produtos">
                <div id="cadastro" style="display: none;">
                    <h4 class="page-header">COMPARTILHAMENTOS</h4>
                    <hr>
                    <form action="" method="POST" enctype="multipart/form-data" name="upload">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nome:</label>
                                <input class="form-control form-control-sm col-md-12 col-sm-12" type="text" name="nome" placeholder="Digite um nome" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Quantidade de passageiros </label>
                                <input class="form-control form-control-sm col-md-12 col-sm-12" type="text" name="qnt_usuarios" placeholder="Ex: 4" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Valor adicional </label>
                                <input class="form-control form-control-sm col-md-12 col-sm-12" type="text" name="porcentagem" placeholder="Ex: 10" />
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="btn_enviar" value="Cadastrar">
                    </form>
                    <hr>
                </div>
            </div>
            <!--Controlador de tamanho e margem da tabela-->
            <div class="row">
                <div class="col-md-6">
                    <h4 class="page-header">LISTA DE COMPARTILHAMENTOS</h4>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-sm" style="float: right;" onclick="mostrar_cadastro()">Cadastrar</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>QNT USUÁRIOS</th>
                        <th>Valor %</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($c->getByCidadeId($cidade_id) as $linha) {
                            echo '<tr>';
                            echo  '<td>' . $linha['id'] . '</td>';
                            echo  '<td>' . $linha['nome'] . '</td>';
                            echo  '<td>' . $linha['qnt_usuarios'] . '</td>';
                            echo  '<td>' . $linha['porcentagem'] . '</td>';
                            //Ações                                      
                            echo  "<td><button type='button' class='btn btn-info'  data-toggle='modal' data-target='#myModal$linha[id]'><i class='bi bi-eye'></i></button>&nbsp";
                            echo "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#editar$linha[id]'><i class='bi bi-pencil'></i></button>&nbsp";
                            echo "<a class='btn btn-info' href='../funcoes/duplicar.php?id=$linha[id]&categoria=compartilhamentos' role='button'><i class='bi bi-arrows-angle-expand'></i></a>&nbsp";
                            echo "<a class='btn btn btn-danger' onclick='deletar(event, {$linha['id']})'  role='button'><i class='bi bi-trash'></i></a>&nbsp</td>";
                            echo "</tr>";
                        ?>
                            <!--Inicio Modal.-->
                            <div class="modal fade" id="myModal<?php echo $linha['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <center>
                                                <h3 class="modal-title" id="myModalLabel"> Compartilhamento id: <?php echo $linha['id']; ?></h3>
                                            </center>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>
                                                <b>Nome: </b><?php echo $linha['nome']; ?><br>
                                                <b>Quantidade de passageiros: </b><?php echo $linha['qnt_usuarios']; ?><br>
                                                <b>Valor adicional: </b><?php echo $linha['porcentagem']; ?><br>
                                            </h4>
                                            <hr>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--fim modal-->
                            <!-- modal editar -->
                            <div class="modal fade" id="editar<?php echo $linha['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar Compartilhamento</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST" enctype="multipart/form-data" name="upload">
                                                <!-- input id hidden -->
                                                <input type="hidden" name="id" value="<?php echo $linha['id']; ?>">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Nome:</label>
                                                        <input class="form-control form-control-sm col-md-12 col-sm-12" type="text" name="nome" value="<?php echo $linha['nome']; ?>" required />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Quantidade de passageiros </label>
                                                        <input class="form-control form-control-sm col-md-12 col-sm-12" type="text" name="qnt_usuarios" value="<?php echo $linha['qnt_usuarios']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Porcentagem Adicional</label>
                                                        <input class="form-control form-control-sm col-md-12 col-sm-12" type="text" name="porcentagem" value="<?php echo $linha['porcentagem']; ?>" />
                                                    </div>
                                                </div>
                                                <input type="submit" class="btn btn-primary" name="btn_editar" value="Editar">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--fim modal editar-->
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!--Fechando container bootstrap-->
    <?php include("dep_query.php"); ?>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script>
        let em_cadastro = false;
        if (localStorage.getItem('em_cadastro') == 'true') {
            mostrar_cadastro();
        }

        function deletar(event, id) {
            event.preventDefault();
            if (confirm("Deseja realmente excluir?")) {
                window.location.href = 'deletar.php?id=' + id + '&categoria=compartilhamentos&location=compartilhamentos.php';
            }
        }

        function mostrar_cadastro() {

            let cadastro = document.getElementById("cadastro");
            if (cadastro.style.display == "none") {
                localStorage.setItem('em_cadastro', true);
                $("#cadastro").animate({
                    opacity: 1,
                    left: "+=50",
                    height: "toggle"
                }, 400, function() {
                    // Animation complete.
                });
            } else {
                localStorage.setItem('em_cadastro', false);
                $("#cadastro").animate({
                    opacity: 1,
                    left: "+=50",
                    height: "toggle"
                }, 400, function() {
                    // Animation complete.
                });
            }
        }
    </script>
</body>

</html>