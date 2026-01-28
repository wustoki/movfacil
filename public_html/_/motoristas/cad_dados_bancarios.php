<?php
include_once "../classes/dados_bancarios.php";
$db = new dados_bancarios();
$motorista_id = $_POST['motorista_id'];
$nome_banco = $_POST['nome_banco'];
$beneficiario = $_POST['beneficiario'];
$chave_pix = $_POST['chave_pix'];
$tipo_chave = $_POST['tipo_chave'];
$dados = $db ->getByMotoristaId($motorista_id);
if($dados){
    $db ->edit($dados['id'], $motorista_id, $tipo_chave, $nome_banco, $beneficiario, $chave_pix);
}else{
    var_dump($db ->insere($motorista_id, $tipo_chave, $nome_banco, $beneficiario, $chave_pix));
}
echo "Dados Bancários cadastrados com sucesso";
?>