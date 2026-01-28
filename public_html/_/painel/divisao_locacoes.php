<?php
include("seguranca.php");
include("../classes/divisao_locacoes.php");
$dl = new divisao_locacoes();

//verifica se foi enviado o formulario
if (isset($_POST['franqueado'])) {
    $franqueado = $_POST['franqueado'];
    $motorista = $_POST['motorista'];
    $locatario = $_POST['locatario'];
    //verifica se os 3 somados da 100%
    if ($franqueado + $motorista + $locatario == 100) {
        //insere no banco
        if ($dl->getByCidadeId($cidade_id)) {
            $dl->editar($cidade_id, $franqueado, $motorista, $locatario);
        } else {
            $dl->insere($cidade_id, $franqueado, $motorista, $locatario);
        }
        echo "<script>alert('Divisão de faturamento salva com sucesso!');</script>";
        echo "<script>window.location.href = 'divisao_locacoes.php';</script>";
    } else {
        echo "<script>alert('A soma das porcentagens deve ser igual a 100%.');</script>";
    }
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
                <h4 class="page-header">Divisão de Faturamento</h4>
                <div class="col-md-12">
                    <form method="POST" action="">
                        <?php
                        $franqueado = $motorista = $locatario = '';
                        if ($dl->getByCidadeId($cidade_id)) {
                            $dados = $dl->getByCidadeId($cidade_id);
                            if (!empty($dados[0])) {
                                $franqueado = $dados[0]['franqueado'];
                                $motorista = $dados[0]['motorista'];
                                $locatario = $dados[0]['locatario'];
                            }
                        }
                        ?>
                        <div class="form-group col-md-4">
                            <label for="franqueado">Percentual do Franqueado</label>
                            <input type="number" class="form-control" id="franqueado" name="franqueado" placeholder="Franqueado" value="<?php echo $franqueado; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="motorista">Percentual do Motorista</label>
                            <input type="number" class="form-control" id="motorista" name="motorista" placeholder="Motorista" value="<?php echo $motorista; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="locatario">Percentual do Locatário</label>
                            <input type="number" class="form-control" id="locatario" name="locatario" placeholder="Locatário" value="<?php echo $locatario; ?>" required>
                        </div>
                        <!-- submit -->
                        <div class="form-group col-md-12">
                            <input id="enviar" type="button" class="btn btn-primary" name="btn_enviar" value="Salvar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("dep_query.php"); ?>
    <script>
        //todos os 3 devem somados dar 100%
        document.getElementById("enviar").addEventListener("click", function(event) {
            event.preventDefault(); // Impede o envio do formulário
            var franqueado = parseFloat(document.getElementById("franqueado").value);
            var motorista = parseFloat(document.getElementById("motorista").value);
            var locatario = parseFloat(document.getElementById("locatario").value);

            if (franqueado + motorista + locatario !== 100) {
                alert("A soma das porcentagens deve ser igual a 100%.");
            } else {
                document.querySelector("form").submit(); // Envia o formulário se a soma for 100%
            }
        });
    </script>
</body>