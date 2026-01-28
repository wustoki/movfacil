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

// Verifica se já existe um checklist para o veículo
$dados_existentes = $c->getChecklistByVeiculoId($veiculo_id);
if(!$dados_existentes || empty($dados_existentes)) {
    // Se não existe, insere um novo
    $checklist_id = $c->insere($veiculo_id);
} else {
    // Se existe, pega o ID do mais recente
    $checklist_id = $dados_existentes[0]['id'];
}

var_dump($checklist_id);

// Atualiza os campos individualmente se eles existirem no POST
if(isset($_POST['pintura_ok'])) {
    $c->setPinturaOk($checklist_id, 1);
} else {
    $c->setPinturaOk($checklist_id, 0);
}

if(isset($_POST['vidros_ok'])) {
    $c->setVidrosOk($checklist_id, 1);
} else {
    $c->setVidrosOk($checklist_id, 0);
}

if(isset($_POST['retrovisores_ok'])) {
    $c->setRetrovisoresOk($checklist_id, 1);
} else {
    $c->setRetrovisoresOk($checklist_id, 0);
}

if(isset($_POST['pneus_ok'])) {
    $c->setPneusOk($checklist_id, 1);
} else {
    $c->setPneusOk($checklist_id, 0);
}

if(isset($_POST['estepe_ok'])) {
    $c->setEstepeOk($checklist_id, 1);
} else {
    $c->setEstepeOk($checklist_id, 0);
}

if(isset($_POST['macaco_ok'])) {
    $c->setMacacoOk($checklist_id, 1);
} else {
    $c->setMacacoOk($checklist_id, 0);
}

if(isset($_POST['chave_roda_ok'])) {
    $c->setChaveRodaOk($checklist_id, 1);
} else {
    $c->setChaveRodaOk($checklist_id, 0);
}

if(isset($_POST['triangulo_ok'])) {
    $c->setTrianguloOk($checklist_id, 1);
} else {
    $c->setTrianguloOk($checklist_id, 0);
}

if(isset($_POST['documentacao_ok'])) {
    $c->setDocumentacaoOk($checklist_id, 1);
} else {
    $c->setDocumentacaoOk($checklist_id, 0);
}

if(isset($_POST['seguro_ok'])) {
    $c->setSeguroOk($checklist_id, 1);
} else {
    $c->setSeguroOk($checklist_id, 0);
}

if(isset($_POST['limpeza_ok'])) {
    $c->setLimpezaOk($checklist_id, 1);
} else {
    $c->setLimpezaOk($checklist_id, 0);
}

if(isset($_POST['combustivel_ok'])) {
    $c->setCombustivelOk($checklist_id, 1);
} else {
    $c->setCombustivelOk($checklist_id, 0);
}

if(isset($_POST['farois_ok'])) {
    $c->setFaroisOk($checklist_id, 1);
} else {
    $c->setFaroisOk($checklist_id, 0);
}

if(isset($_POST['setas_ok'])) {
    $c->setSetasOk($checklist_id, 1);
} else {
    $c->setSetasOk($checklist_id, 0);
}

if(isset($_POST['buzina_ok'])) {
    $c->setBuzinaOk($checklist_id, 1);
} else {
    $c->setBuzinaOk($checklist_id, 0);
}

if(isset($_POST['detalhes'])) {
    $c->setDetalhes($checklist_id, $_POST['detalhes']);
}

echo "<script>alert('Checklist salvo com sucesso!');window.location.href='veiculos.php'</script>";
exit;
?>