<?php
$config = require __DIR__ . '/db.php';

if (!isset($_GET['token']) || $_GET['token'] !== $config['token']) {
  http_response_code(403);
  exit('forbidden');
}

try {
  $pdo = new PDO($config['dsn'], $config['user'], $config['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);

  // AJUSTE: Inclui o evento 'cliente_cadastrado' na busca
  $stmt = $pdo->query("
    SELECT id, event_type, payload
    FROM integracao_outbox
    WHERE delivered_at IS NULL
      AND tries < 5
      AND (event_type = 'motorista_cadastrado' OR event_type = 'motorista_aprovado' OR event_type = 'cliente_cadastrado')
    ORDER BY id ASC
    LIMIT 50
  ");
  $events = $stmt->fetchAll();

  $sent = 0;
  $failed = 0;

  foreach ($events as $ev) {
    $payload_original = json_decode($ev['payload'], true) ?: [];
    $payload = [];

    // Busca os dados do motorista e da cidade para eventos de motorista
    if (($ev['event_type'] == 'motorista_cadastrado' || $ev['event_type'] == 'motorista_aprovado') && !empty($payload_original['id_tabela'])) {
      $q = $pdo->prepare("
        SELECT
          m.nome,
          m.telefone,
          m.email,
          m.placa,
          m.cpf,
          m.ativo AS status,
          c.id AS cidade_id,
          c.nome AS cidade_nome,
          c.latitude,
          c.longitude
        FROM
          motoristas m
        LEFT JOIN
          cidades c ON m.cidade_id = c.id
        WHERE m.id = ?
      ");
      $q->execute([$payload_original['id_tabela']]);
      if ($m = $q->fetch()) {
        $cidade_nome = $m['cidade_nome'] ?? '';
        $uf = '';
        if (strpos($cidade_nome, '/') !== false) {
          $partes = explode('/', $cidade_nome);
          $cidade_nome = trim($partes[0]);
          $uf = trim($partes[1]);
        }
        $payload = [
          'id_tabela' => $payload_original['id_tabela'],
          'nome' => $m['nome'],
          'telefone' => $m['telefone'],
          'email' => $m['email'],
          'placa' => $m['placa'],
          'cpf' => $m['cpf'],
          'cidade_id' => $m['cidade_id'],
          'cidade_nome' => $cidade_nome,
          'cidade_uf' => $uf,
          'latitude' => $m['latitude'],
          'longitude' => $m['longitude'],
          'status' => $m['status'],
        ];
      }
    }

   // NOVO TRECHO: Busca os dados do cliente e da cidade para eventos de cliente
if ($ev['event_type'] == 'cliente_cadastrado' && !empty($payload_original['id_tabela'])) {
  $q = $pdo->prepare("
    SELECT
      c.id,
      c.nome,
      c.telefone,
      c.email,
      c.cpf,
      c.ativo,
      cid.nome AS cidade_nome,
      c.cidade_id
    FROM clientes c
    LEFT JOIN cidades cid ON c.cidade_id = cid.id
    WHERE c.id = ?
  ");
  $q->execute([$payload_original['id_tabela']]);
  if ($cliente = $q->fetch()) {
    // Converte 0/1 para "bloqueado"/"ativo"
    $status = ($cliente['ativo'] == 1) ? 'ativo' : 'bloqueado';

    $payload = [
      'id_tabela'   => $cliente['id'],
      'nome'        => $cliente['nome'],
      'telefone'    => $cliente['telefone'],
      'email'       => $cliente['email'],
      'cpf'         => $cliente['cpf'],
      'cidade_id'   => $cliente['cidade_id'],
      'cidade_nome' => $cliente['cidade_nome'], 
      'status'      => $status
    ];
  }
}

    $ch = curl_init($config['webhook_url']);
    curl_setopt_array($ch, [
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
      CURLOPT_POSTFIELDS => json_encode([
        'event' => $ev['event_type'],
        'data'  => $payload,
        'sent_at' => date('c')
      ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
      CURLOPT_TIMEOUT => 15
    ]);
    $resp = curl_exec($ch);
    $err  = curl_error($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($err || $code < 200 || $code >= 300) {
      $upd = $pdo->prepare("
        UPDATE integracao_outbox
        SET tries = tries + 1, last_error = ?, updated_at = NOW()
        WHERE id = ?
      ");
      $upd->execute([substr("HTTP $code | $err | $resp", 0, 1000), $ev['id']]);
      $failed++;
    } else {
      $upd = $pdo->prepare("
        UPDATE integracao_outbox
        SET delivered_at = NOW(), updated_at = NOW()
        WHERE id = ?
      ");
      $upd->execute([$ev['id']]);
      $sent++;
    }
  }

  header('Content-Type: application/json');
  echo json_encode(['ok' => true, 'sent' => $sent, 'failed' => $failed], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
  http_response_code(500);
  echo "erro: " . $e->getMessage();
}