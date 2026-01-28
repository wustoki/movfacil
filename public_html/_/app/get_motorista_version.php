<?php
header('Content-Type: application/json');

// Mude este número de versão sempre que você fizer uma nova atualização do APK
$latest_version = '1.0.1';

// O URL do seu novo APK no servidor
$apk_url = 'https://wustoki.top/apk/motorista-v' . $latest_version . '.apk';

$response = [
    'version' => $latest_version,
    'download_url' => $apk_url
];

echo json_encode($response);
?>