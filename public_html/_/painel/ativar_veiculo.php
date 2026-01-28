<?php
// Incluir arquivo de conexão
require_once '../classes/veiculos.php';

$v = new veiculos();

// Verificar se o ID foi fornecido na URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Capturar o ID do veículo
    $id = intval($_GET['id']);
    $v -> setStatus($id, 1);
    // Redirecionar para a lista de veículos
    echo '<script>alert("Veículo ativado com sucesso!");</script>'; 
    echo '<script>window.location.href="veiculos.php";</script>';
} else {
    // Caso não tenha recebido ID, redirecionar
    echo '<script>alert("Veículo não encontrado!");</script>';
    echo '<script>window.location.href="veiculos.php";</script>';
    exit;
}
?>