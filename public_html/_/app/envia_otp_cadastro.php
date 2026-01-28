<?php
header("Access-Control-Allow-Origin: *");
include '../classes/otp_verifications.php';
include '../bd/config.php';

$otp_verifications = new otp_verifications();


$numero_telefone = $_POST['numero_telefone'];
if($numero_telefone == ""){
    echo json_encode(array('status' => 'erro', 'mensagem' => 'Número de telefone não informado'));
    exit;
}
$numero_telefone = str_replace("(", "", $numero_telefone);
$numero_telefone = str_replace(")", "", $numero_telefone);
$numero_telefone = str_replace("-", "", $numero_telefone);
$numero_telefone = str_replace(" ", "", $numero_telefone);


$otp = $otp_verifications->insere("55" . $numero_telefone);

$numero_telefone = "55" . $numero_telefone;


$msg = "Seu codigo e: " . $otp . ". @wustoki.top #" . $otp;
$api_key = API_KEY_SMS;
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.smsdev.com.br/v1/send?key=" . $api_key . "&type=9&number=" . $numero_telefone . "&msg=" . urlencode($msg),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
echo json_encode(array('status' => 'ok', 'response' => $response));

?>