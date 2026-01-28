<?php
include("seguranca.php");
include_once "../classes/veiculos.php";
include("../classes/upload.php");
$v = new veiculos();


$placa = $_POST['placa'];
$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$ano = $_POST['ano'];
$cor = $_POST['cor'];
$categoria = $_POST['categoria'];
$tipo_combustivel = $_POST['tipo_combustivel'];
$vencimento = $_POST['vencimento'] ?? "";

//editar
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $v->editar($id, $placa, $modelo, $marca, $ano, $cor, $categoria, $tipo_combustivel);
    $km_atual = $_POST['km_atual'];
    $v ->setKmAtual($id, $km_atual);
    if($vencimento != ""){
        $v ->setVencimento($id, $vencimento);
    }

    //parametros para imagem
    $pasta = '../admin/uploads/';

    // Check each image separately and only process if it was uploaded
    if (!empty($_FILES['img_frente']['name'])) {
        $upload = new Upload($_FILES['img_frente'], 800, 800, $pasta);
        $img_nome = $upload->salvar();
        if ($img_nome) {
            $v->setImgFrente($id, $img_nome);
        }
    }

    if (!empty($_FILES['img_traseira']['name'])) {
        $upload = new Upload($_FILES['img_traseira'], 800, 800, $pasta);
        $img_nome = $upload->salvar();
        if ($img_nome) {
            $v->setImgTraseira($id, $img_nome);
        }
    }

    if (!empty($_FILES['img_lateral_direita']['name'])) {
        $upload = new Upload($_FILES['img_lateral_direita'], 800, 800, $pasta);
        $img_nome = $upload->salvar();
        if ($img_nome) {
            $v->setImgLatDireita($id, $img_nome);
        }
    }

    if (!empty($_FILES['img_lateral_esquerda']['name'])) {
        $upload = new Upload($_FILES['img_lateral_esquerda'], 800, 800, $pasta);
        $img_nome = $upload->salvar();
        if ($img_nome) {
            $v->setImgLatEsquerda($id, $img_nome);
        }
    }

    if (!empty($_FILES['img_documento']['name'])) {
        $upload = new Upload($_FILES['img_documento'], 800, 800, $pasta);
        $img_nome = $upload->salvar();
        if ($img_nome) {
            $v->setImgDocumento($id, $img_nome);
        }
    }

    echo "<script>alert('Veículo editado com sucesso!');</script>";
    echo "<script>location.href = 'veiculos.php';</script>";
}else{
    $v->insere($_SESSION['user_id'], $placa, $modelo, $marca, $ano, $cor, $categoria, $tipo_combustivel);
    echo "<script>alert('Veículo cadastrado com sucesso!');</script>";
    echo "<script>location.href = 'veiculos.php';</script>";
}
?>
