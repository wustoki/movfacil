<?php 
include("seguranca.php");
include_once("../classes/franqueados.php");
include_once("../classes/cobranca.php");
include "../classes/upload.php";
$u = new franqueados(); 
$c = new cobranca();

$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$cidade_id = $_POST['cidade_id'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$comissao = $_POST['comissao'];
$limite_credito_motorista = $_POST['limite_credito_motorista']; 
$acesso = $_POST['acesso'];
$cpf = $_POST['cpf'];
$cnpj = $_POST['cnpj'];
$nome_empresa = $_POST['nome_empresa'];
$pasta = '../admin/uploads/';

$doc_empresa = $_FILES['doc_empresa'];
$doc_pessoal = $_FILES['doc_pessoal'];
$comp_endereco = $_FILES['comp_endereco'];
$imagens = array(
	$doc_empresa,
	$doc_pessoal,
	$comp_endereco
);
$imagens_fim = array();
if (is_dir($pasta)) {
	for ($index = 0; $index < count($imagens); $index++) {
		if ($imagens[$index]['error'] == UPLOAD_ERR_OK) {
			$upload = new Upload($imagens[$index], 800, 800, $pasta);
			$imagens_fim[] = $upload->salvar();
		} else {
			$imagens_fim[] = "";
		}
	}
}

//edita usuario
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$u->edit_usuario($id, $nome, $usuario, $senha, $cidade_id, $comissao, $telefone, $email, $limite_credito_motorista);
	$u->setAcesso($id, $acesso);
	$u->setCpf($id, $cpf);
	$u->setCnpj($id, $cnpj);
	$u->setNomeEmpresa($id, $nome_empresa);
	if($imagens_fim[0] != ""){
		$u->setDocEmpresa($id, $imagens_fim[0]);
	}
	if($imagens_fim[1] != ""){
		$u->setDocPessoal($id, $imagens_fim[1]);
	}
	if($imagens_fim[2] != ""){
		$u->setCompEndereco($id, $imagens_fim[2]);
	}

	echo '<script>alert("Franqueado editado com sucesso!");</script>';
	echo '<script>window.location.href="franqueados.php";</script>';
}
