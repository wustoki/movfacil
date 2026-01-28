<?php
// Tenta incluir o arquivo de configuração
$path = __DIR__ . '/../integraçoes/integracao/db.php';

echo "Tentando carregar o arquivo de configuração de: <b>" . htmlspecialchars($path) . "</b><br><br>";

if (file_exists($path)) {
    // Se o caminho existir, vamos incluir e tentar executar
    echo "Caminho do arquivo de configuração encontrado com sucesso.<br>";
    $config = require $path;

} else {
    // Se o caminho NÃO existir, vamos mostrar o erro e parar a execução
    echo "<h1>ERRO CRÍTICO!</h1>";
    echo "O arquivo de configuração não foi encontrado no caminho:<br>";
    echo "<b>" . htmlspecialchars($path) . "</b><br><br>";
    echo "Por favor, verifique se a sua estrutura de pastas está correta, incluindo o 'ç' no nome da pasta 'integraçoes'.";
    exit; // Pare a execução aqui
}

// O script vai continuar a partir daqui somente se o arquivo db.php for encontrado
if (!isset($_GET['id'])) {
    echo "Erro: ID do motorista não informado. Verifique o link de redirecionamento em aprovar_motorista.php.";
    exit;
}

$id_tabela = $_GET['id'];

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
  echo "<h1>SUCESSO!</h1>";
  echo "Evento de aprovação inserido com sucesso para o motorista ID: " . $id_tabela . "<br><br>";
} catch (Throwable $e) {
  echo "<h1>ERRO NO BANCO DE DADOS!</h1>";
  echo "Erro ao gravar evento de motorista aprovado: " . $e->getMessage();
}

echo "<br>FIM DA EXECUÇÃO. Verifique a tabela `integracao_outbox` para confirmar a inserção.";