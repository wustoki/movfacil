<?php
include("../classes/motorista_docs.php");
include("../classes/upload.php");
include "../classes/alertas.php";
include("../classes/motoristas.php");
$md = new motorista_docs();
$a = new alertas();
$mt = new motoristas();
//entrada de formulário

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$telefone=  $_POST['telefone'];
$cidade_id =  $_POST['cidade_id'];
$veiculo = $_POST['veiculo'];
$placa = $_POST['placa'];
$email = $_POST['email'];


if($md ->verifica_cpf($cpf)){
    echo "<script>alert('CPF já cadastrado!'); window.location.href='index.php';</script>";
}else{

        //parametros para imagem

        $pasta='../admin/uploads/';
    
        $img_cnh=$_FILES['img_cnh'];
        $img_documento = $_FILES['img_documento'];
        $img_lateral = $_FILES['img_lateral'];
        $img_frente = $_FILES['img_frente'];
        $img_selfie = $_FILES['img_selfie'];
        
        $imagens = array(
            $img_cnh, $img_documento, $img_lateral, $img_frente, $img_selfie
        );
        $imagens_fim= array();
        if(is_dir($pasta)){
        for ($index = 0; $index < count($imagens); $index++){
                $upload = new Upload($imagens[$index], 800, 800, $pasta);
        					$imagens_fim[] = $upload->salvar();
            }
        }
        
        //echo json_encode($imagens_fim);
        $id_md = $md ->insert($cidade_id, $nome, $cpf, $senha, $telefone, $veiculo, $placa, $imagens_fim[0], $imagens_fim[1], $imagens_fim[2], $imagens_fim[3], $imagens_fim[4], $email);

        $id = $mt->cadastrar_motorista($cidade_id, $nome, $cpf, $imagens_fim[4], $veiculo, $placa, $telefone, $senha, 0, 0, 00);
        $mt->updateEmail($id, $email);
        $mt->bloquearMotorista($id);

        $md->updateIdTabela($id_md, $id);

        $a->insereAlerta($cidade_id, "Novo motorista aguardando aprovação", "lista_motoristas_temp.php");

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='index.php';</script>";
}

?>