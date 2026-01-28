<?php
//desativa erros
//error_reporting(0);
//ini_set("display_errors", 0 );
$hostname = "localhost";  //geralmente não precisa mudar, mas vc pode colocar o ip da hospedagem em alguns casos
$user = "movfacil";  //usuario que você criou no banco de dados
$password = "luna2017";  //senha que vc criou do banco de dados
$database = "movfacil";  //nome do banco de dados
$conexao = mysqli_connect($hostname,$user,$password,$database);  //procedimento que conecta ao banco de dados, nao alterar
$pdo = new PDO('mysql:host=localhost;dbname='.$database.'', $user, $password);
$secret = "abc1234";  //senha para acesso a api do aplicativo (somente numeros e letras)
date_default_timezone_set('America/Sao_Paulo'); //mude para o da sua regiao mais em https://www.php.net/manual/en/timezones.america.php

if (!$conexao){  // caso a conexao falhe
    print "Falha na Conexão com o Banco de Dados";
}