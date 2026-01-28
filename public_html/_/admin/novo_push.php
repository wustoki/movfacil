<?
include("seguranca.php");
include("../bd/config.php");
include("head.php");
include("menu.php");
?>

<body>
    <div class="container-fluid">
    </div>
    <div class="container">
        <div class="container-principal-produtos">
            <h4 class="page-header">Enviar Notificação Push</h4>
            <hr>
            <form action="send_push.php" method="POST" enctype="multipart/form-data" name="upload">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Título da mensagem: </label>
                        <input class="form-control form-control-sm col-md-10 col-sm-10" type="text" name="titulo" placeholder="Ex: Vai sair?" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Conteúdo da mensagem: </label>
                        <textarea class="form-control form-control-sm col-md-10 col-sm-10" type="text" name="mensagem" placeholder="Ex: Chame o motorista em nosso app!" rows="3"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="destino" id="destino" class="form-control form-control-sm col-md-10 col-sm-10">
                            <option value="1">Motoristas</option>
                            <option value="2">Usuários</option>
                            <option value="3">Todos</option>
                        </select>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="btn_enviar" value="Enviar Push">
            </form>
            <br>
        </div>
    </div><!--Fechando container bootstrap-->
    <?php include("dep_query.php"); ?>
</body>

</html>