<?php
include("seguranca.php");
include("nivel_acesso.php");
include "../classes/motoristas.php";
include "../classes/upload.php";

$m = new motoristas();

//entrada de formulário
$nome = $_POST['nome'];
$telefone = $_POST['fone'];
$cpf =$_POST['cpf'];
$veiculo = $_POST['veiculo'];
$placa= $_POST['placa'];
$senha= $_POST['senha'];
$taxa = $_POST['taxa'];
$saldo = $_POST['saldo'];
$ids_categorias = $_POST['ids_categorias'];

//parametros para imagem
$pasta='../admin/uploads/';
$img=$_FILES['img'];
if($img['name'] != ""){
    $upload = new Upload($img, 800, 800, $pasta);
    $nome_img = $upload->salvar();
    echo $nome_img;
}else{
    $nome_img = "sem_imagem.jpg";
}

$cadastrar = $m->cadastrar_motorista($cidade_id, $nome, $cpf, $nome_img, $veiculo, $placa, $telefone, $senha, $taxa, $saldo, $ids_categorias);
if($cadastrar){
    echo '<script>alert("Motorista cadastrado com sucesso!");</script>';
    echo '<script>window.location.href="listar_motoristas.php";</script>';
} else {
    echo '<script>alert("Erro ao cadastrar motorista!");</script>';
    echo '<script>window.location.href="listar_motoristas.php";</script>';
}

?>