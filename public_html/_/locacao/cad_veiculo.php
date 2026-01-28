<?php
include("../bd/config.php");
include("../classes/upload.php");
include_once "../classes/clientes.php";
include_once "../classes/veiculos.php";

$c = new clientes();
$v = new veiculos();


$telefone = $_POST['telefone'];
$senha = $_POST['senha'];

$cliente = $c->login($telefone, $senha);
if ($cliente) {
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = $_POST['ano'];
    $cor = $_POST['cor'];
    $categoria = $_POST['categoria'];
    $tipo_combustivel = $_POST['tipo_combustivel'];



    //verifica se o veiculo ja esta cadastrado pela placa
    $veiculo = $v->getByPlaca($placa);
    if ($veiculo) {
        echo "<script>alert('Veículo já cadastrado!');</script>";
        echo "<script>location.href = 'cadastro_veiculo.php';</script>";
    } else {
        $id =  $v->insere($cliente['id'], $placa, $modelo, $marca, $ano, $cor, $categoria, $tipo_combustivel);

        //parametros para imagem
        $pasta = '../admin/uploads/';

        $img_frente = $_FILES['img_frente'];
        $img_traseira = $_FILES['img_traseira'];
        $img_lat_direita = $_FILES['img_lateral_direita'];
        $img_lat_esquerda = $_FILES['img_lateral_esquerda'];
        $img_documento = $_FILES['img_documento'];

        $imagens = array(
            $img_frente,
            $img_traseira,
            $img_lat_direita,
            $img_lat_esquerda,
            $img_documento
        );
        $imagens_fim = array();

        if (is_dir($pasta)) {
            for ($index = 0; $index < count($imagens); $index++) {
                $upload = new Upload($imagens[$index], 800, 800, $pasta);
                $imagens_fim[] = $upload->salvar();
            }
        }

        $v ->setImgFrente($id, $imagens_fim[0]);
        $v ->setImgTraseira($id, $imagens_fim[1]);
        $v ->setImgLatDireita($id, $imagens_fim[2]);
        $v ->setImgLatEsquerda($id, $imagens_fim[3]);
        $v ->setImgDocumento($id, $imagens_fim[4]);

        echo "<script>alert('Veículo cadastrado com sucesso!');</script>";
        echo "<script>location.href = 'veiculos.php';</script>";
    }
} else {
    echo "<script>alert('Usuário ou senha inválidos!');</script>";
    echo "<script>location.href = 'cadastro_veiculo.php';</script>";
}
