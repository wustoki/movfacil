<?php
// Inclui o arquivo de configuração do banco de dados, que contém as credenciais.
// Este é o caminho correto para a sua estrutura de pastas.
$config = require __DIR__ . '/../integracoes/integracao/db.php';

ini_set('default_charset', 'UTF-8');
include("seguranca.php");
include("nivel_acesso.php");
include("../classes/motorista_docs.php");
include("../classes/motoristas.php");
include("../classes/send_mail.php");

$id = $_GET['id'];

$md = new motorista_docs();
$mt = new motoristas();
$email = new enviaEmail();
$dados_motorista = $md->get_by_id($id);
$id_tabela = $dados_motorista['id_tabela'];

$dados_motorista = $mt->get_motorista($id_tabela);

// Verifica se a data de validade da CNH e do documento foram preenchidas
if ($dados_motorista['validade_cnh'] == "" || $dados_motorista['validade_doc_veiculo'] == "") {
    echo "<script>alert('Preencha a data de validade da CNH e do documento do veículo!'); window.location.href='lista_motoristas_temp.php';</script>";
    exit;
}

$md->aprovado($id);
$mt->desbloquearMotorista($id_tabela);

if ($id) {
    // AQUI É O CÓDIGO para a automação
    try {
      $pdo = new PDO($config['dsn'], $config['user'], $config['pass']);
      $novo_payload = [
        'id_tabela' => $id_tabela,
      ];
      $q = $pdo->prepare("
        INSERT INTO integracao_outbox (event_type, payload)
        VALUES ('motorista_aprovado', ?)
      ");
      $q->execute([json_encode($novo_payload)]);
    } catch (Throwable $e) {
      // Ação de contingência em caso de erro na gravação do evento
      error_log("Erro ao gravar evento de motorista aprovado: " . $e->getMessage());
    }

    $email->sendEmail($dados_motorista['email'], "Cadastro Aprovado", "Seu cadastro foi aprovado com sucesso! Agora você já pode começar a trabalhar com a nossa plataforma!");
    echo "<script>alert('Motorista aprovado com sucesso!'); window.location.href='lista_motoristas_temp.php';</script>";
} else {
    echo "<script>alert('Erro ao aprovar motorista!'); window.location.href='lista_motoristas_temp.php';</script>";
}