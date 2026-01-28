<?php
include("seguranca.php");
include("../classes/motorista_docs.php");
include("../classes/motoristas.php");

// 1. Recebe o ID do registro da tabela temporária (motorista_docs).
$id_doc = $_GET['id'];

$md = new motorista_docs();
$mt = new motoristas();

// 2. Busca os dados na tabela temporária para encontrar o ID da tabela principal.
$dados_doc = $md->get_by_id($id_doc);

if ($dados_doc) {
    // Pega o ID da tabela principal 'motoristas'.
    $id_tabela_principal = $dados_doc['id_tabela'];

    // 3. Bloqueia o motorista na tabela principal, movendo-o para a lista de "inativos" (ativo = 2).
    $mt->bloquearMotorista($id_tabela_principal);

    // 4. Deleta o registro da tabela temporária para limpar a fila de "Aguardando Aprovação".
    // Usamos a conexão direta, pois a classe motorista_docs não possui um método de exclusão.
    include("../bd/conexao.php"); // Garante que $conexao está disponível
    $query_delete = "DELETE FROM motorista_docs WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $query_delete);
    mysqli_stmt_bind_param($stmt, "i", $id_doc);
    mysqli_stmt_execute($stmt);

    // Redireciona de volta para a lista com uma mensagem de sucesso.
    echo "<script>alert('O motorista foi REPROVADO e movido para a lista de desativados.'); window.location.href='lista_motoristas_temp.php';</script>";
} else {
    // Caso o registro não seja encontrado, redireciona com uma mensagem de erro.
    echo "<script>alert('ERRO: Não foi possível encontrar o registro do motorista para reprovação.'); window.location.href='lista_motoristas_temp.php';</script>";
}
?>
