<?php
// Teste simples para verificar conexão e inserção em integracao_outbox
ini_set('display_errors', 1);
error_reporting(E_ALL);

$logFile = sys_get_temp_dir() . '/wustoki_test_outbox.log';
file_put_contents($logFile, date('c') . " - test_outbox.php iniciado\n", FILE_APPEND);

// tenta localizar config.php em caminhos comuns
$paths = [
  __DIR__ . '/bd/config.php',
  __DIR__ . '/../bd/config.php',
  __DIR__ . '/../../bd/config.php',
  __DIR__ . '/config.php',
  __DIR__ . '/../config.php'
];

$config = null;
$configPath = null;
foreach ($paths as $p) {
  if (file_exists($p)) {
    $config = require $p;
    $configPath = $p;
    break;
  }
}

if (!$config) {
  file_put_contents($logFile, date('c') . " - config.php não encontrado nos caminhos testados\n", FILE_APPEND);
  echo json_encode(['ok'=>false, 'error'=>'config.php não encontrado', 'log'=>$logFile]);
  exit;
}

file_put_contents($logFile, date('c') . " - usando config em: $configPath\n", FILE_APPEND);

try {
  $pdo = new PDO($config['dsn'], $config['user'], $config['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
  $db = $pdo->query("SELECT DATABASE() AS db")->fetchColumn();
  file_put_contents($logFile, date('c') . " - conectado no banco: $db\n", FILE_APPEND);

  // insere evento de teste
  $payload = json_encode(['id_tabela' => 999999], JSON_UNESCAPED_UNICODE);
  $q = $pdo->prepare("INSERT INTO integracao_outbox (event_type, payload) VALUES ('cliente_cadastrado_test', ?)");
  $q->execute([$payload]);

  file_put_contents($logFile, date('c') . " - inserido teste na outbox id: " . $pdo->lastInsertId() . "\n", FILE_APPEND);
  echo json_encode(['ok'=>true, 'db'=>$db, 'insert_id'=>$pdo->lastInsertId(), 'log'=>$logFile]);

} catch (Throwable $e) {
  file_put_contents($logFile, date('c') . " - erro: " . $e->getMessage() . "\n", FILE_APPEND);
  echo json_encode(['ok'=>false, 'error'=>$e->getMessage(), 'log'=>$logFile]);
}
