<?php
include_once "../classes/motoristas.php";
include_once "../classes/dados_bancarios.php"; 
$m = new motoristas();
$db = new dados_bancarios();
$cpf = $_GET['cpf'];
$senha = $_GET['senha'];
$dados_login = $m -> login_motorista($cpf, $senha);
$motorista_id = $dados_login['id'];
if(!$dados_login){
    echo "Dados do motorista não encontrados";
    exit;
}
$dados = $db -> getByMotoristaId($motorista_id);
?>
<?php include "../cadastro/head.php"; ?>
<!doctype html>
</div>
<div class="container">
    <div class="container-principal-produtos">
        <h4 class="page-header">Dados Bancários</h4>
        <hr>
        <form action="#" method="POST" enctype="multipart/form-data" name="upload">
            <div class="row">
                <div class="form-group col-md-8">
                    <label>Nome do Banco:</label>
                    <input class="form-control form-control-sm col-md-09 col-sm-09" type="text" name="nome_banco" required placeholder="Nome do Banco" <?php if($dados['nome_banco']){ echo "value='".$dados['nome_banco']."'"; } ?> />
                    </br>
                    <label>Beneficiário:</label>
                    <input class="form-control form-control-sm col-md-09 col-sm-09" type="text" name="beneficiario" required placeholder="Beneficiário" <?php if($dados['beneficiario']){ echo "value='".$dados['beneficiario']."'"; } ?> />
                    </br>
                    <label>Chave PIX:</label>
                    <input class="form-control form-control-sm col-md-09 col-sm-09" type="text" name="chave_pix" required placeholder="Chave PIX" <?php if($dados['chave_pix']){ echo "value='".$dados['chave_pix']."'"; } ?> />
                    </br>
                    <label>Tipo de Chave:</label>
                    <select name="tipo_chave" class="form-control form-control-sm col-md-10 col-sm-10" placeholder="Selecione o Tipo de Chave" required>
                        <option value="CPF">CPF</option>
                        <option value="CNPJ">CNPJ</option>
                        <option value="E-mail">E-mail</option>
                        <option value="Telefone">Telefone</option>
                    </select>
                    <br>
                    <input type="hidden" name="motorista_id" value="<?php echo $motorista_id; ?>" />
                    <button id="enviar" class="btn btn-primary">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script>

    $(document).ready(function(){
        $("#enviar").click(function(e){
            e.preventDefault();
            var formData = new FormData($("form[name='upload']")[0]);
            $.ajax({
                url: 'cad_dados_bancarios.php',
                type: 'POST',
                data: formData,
                success: function (data) {
                    console.log("ok_dados");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
</script>

