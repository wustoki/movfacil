<?php
include("seguranca.php");

// Sanitização básica
$mensagem = htmlspecialchars(trim($_POST['mensagem'] ?? ''), ENT_QUOTES, 'UTF-8');
$titulo   = htmlspecialchars(trim($_POST['titulo'] ?? ''), ENT_QUOTES, 'UTF-8');
$destino  = intval($_POST['destino'] ?? 0);

// Configurações separadas (recomendado mover para arquivo externo)
$config = [
  'motoristas' => [
    'app_id' => 'df3f3d0f-0318-4993-bbde-b1d363b49bf3',
    'api_key' => 'ODI2MGUyZTAtYjE2NC00ZGQzLWEzZDItNmJiZTYzOTQyNDhj'
  ],
  'usuarios' => [
    'app_id' => 'e5dfc721-20d2-4271-8113-e9c13c6b4af4',
    'api_key' => 'os_v2_app_4xp4oija2jbhdait5haty22k6rqaujxexwzeprunqmw4sxkavqsdtauwimobcindobcbmmlrjahsqpvhxe46vs2eu5rck7ylj7nmlqa'
  ]
];

// Função genérica de envio
function sendMessage($app_id, $msg, $title, $key_one_signal) {
    $content = ["en" => $msg];
    $headings = ["en" => $title];

    $fields = [
        'app_id' => $app_id,
        'included_segments' => ['All'],
        'contents' => $content,
        'headings' => $headings
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $key_one_signal
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Envio condicional
switch ($destino) {
    case 1:
        $response = sendMessage($config['motoristas']['app_id'], $mensagem, $titulo, $config['motoristas']['api_key']);
        break;
    case 2:
        $response = sendMessage($config['usuarios']['app_id'], $mensagem, $titulo, $config['usuarios']['api_key']);
        break;
    case 3:
        $response_motoristas = sendMessage($config['motoristas']['app_id'], $mensagem, $titulo, $config['motoristas']['api_key']);
        $response_usuarios = sendMessage($config['usuarios']['app_id'], $mensagem, $titulo, $config['usuarios']['api_key']);
        $response = json_encode(['motoristas' => $response_motoristas, 'usuarios' => $response_usuarios]);
        break;
    default:
        echo "<script>alert('Destino inválido!'); location.href='novo_push.php';</script>";
        exit;
}

// Verifica resultado
$responseData = json_decode($response, true);
if (isset($responseData['errors'])) {
    $erro = implode(', ', $responseData['errors']);
    echo "<script>alert('Erro ao enviar push: $erro'); location.href='novo_push.php';</script>";
} else {
    echo "<script>alert('Push enviado com sucesso!'); location.href='novo_push.php';</script>";
}
?>