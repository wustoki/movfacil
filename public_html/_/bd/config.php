<?php 
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo'); //mude para o da sua regiao
define ('DOMINIO','https://movfacil.com.br'); //mude para o seu dominio
define ('APP_NAME','MovFacil'); //mude para o nome do seu app
define ('KEY_GOOGLE_MAPS', 'AIzaSyB8DXMpRNHPiqKsDK225wEROupDxVg0s_o'); //mudar para chave de api da sua conta

define ('URL', DOMINIO . '/_/app/');
define ('URL_IMAGEM', DOMINIO . '/_/admin/uploads/');
define('API_KEY_SMS', 'FB488L98FFBPUZ6Q0VE7NGXQ7PU7LDKJDAZTU2GNHU5DHWLUB68AJ27M1YGTZURTQAJO2NEIPJL4CILJV3I4GR5F9FNTW7H85O1JJZC1PUFVLS5X2YYFLW80Q6HYVVQU');
//altere para a sua em https://smsdev.com.br

define('MP_ACCESS_TOKEN', 'APP_USR-5879710375985949-091617-56234589abac83c371cfdda44f628d95-204465364'); //mudar para produção
?>