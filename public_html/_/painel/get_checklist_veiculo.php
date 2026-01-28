<?php
include "seguranca.php";
include_once '../classes/checklist_veiculos.php';

// Recebe o ID do veículo
$veiculo_id = isset($_POST['veiculo_id']) ? $_POST['veiculo_id'] : 0;
if(empty($veiculo_id)) {
    echo "Erro: ID do veículo não fornecido";
    exit;
}

// Instancia a classe
$c = new checklist_veiculos();

//retorna com os dados do checklist
$dados_existentes = $c->getChecklistByVeiculoId($veiculo_id);

// Se encontrou dados, retorna em formato JSON
if ($dados_existentes) {
    echo json_encode($dados_existentes);
} else {
    // Retorna um objeto vazio para evitar erros no parsing JSON
    echo json_encode(null);
}
