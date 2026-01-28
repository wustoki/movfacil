<?php
header("Content-type: text/html; charset=utf-8");
include("seguranca.php");
include("../classes/veiculos.php");
$v = new veiculos();
?>
<!doctype html>
<html lang="pt-br">
<?php include("head.php"); ?>

<body>
    <div class="container-fluid">
    </div>
    <?php
    include("menu.php");
    $id = $_GET['id'];
    $linha = $v->getById($id);
    $img = array(
        $linha['img_frente'],
        $linha['img_traseira'],
        $linha['img_lat_direita'],
        $linha['img_lat_esquerda'],
        $linha['img_documento']
    );
    ?>
    <div class="container">
        <div class="container-principal-produtos">
            <hr>
            <div class="row">

                <div class="col-md-4">
                    <h4 class="page-header">Imagens do Veículo </h4>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-outline-warning" href="veiculos.php" role="button">VOLTAR</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="div-center">

                        <div class="gallery">
                            <?php
                            for ($i = 0; $i < count($img); $i++) {
                                $imageThumbURL = IMG_DIR . $img[$i];
                                $imageURL = IMG_DIR . $img[$i];
                            ?>
                                <a href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-caption="Imagem">
                                    <img width=150 src="<?php echo $imageThumbURL; ?>" alt="" />
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-md-8">
                <b>Modelo: </b><?php echo $linha['modelo']; ?><br>
                <b>Marca: </b><?php echo $linha['marca']; ?><br>
                <b>Ano: </b><?php echo $linha['ano']; ?><br>
                <b>Cor: </b><?php echo $linha['cor']; ?><br>
                <b>Categoria: </b><?php echo $linha['categoria']; ?><br>
                <b>Tipo de Combustível: </b><?php echo $linha['tipo_combustivel']; ?><br>
                <b>Placa: </b><?php echo $linha['placa']; ?><br>
                <b>Vencimento: </b><?php echo date('d/m/Y', strtotime($linha['vencimento'])); ?><br>
            </div>

        </div>
    </div>
    <!-- JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://demos.codexworld.com/includes/js/bootstrap.js"></script>
    <!-- Fancybox CSS library -->
    <link rel="stylesheet" href="fancybox/jquery.fancybox.css">
    <!-- Fancybox JS library -->
    <script src="fancybox/jquery.fancybox.js"></script>
    </head>
    </div>
    <?php include("dep_query.php"); ?>
    <script>
        $("[data-fancybox]").fancybox();
    </script>
</body>

</html>