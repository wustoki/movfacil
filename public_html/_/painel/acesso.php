<?php
include_once '../classes/franqueados.php'; 
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$l = new franqueados();
//login
if($l->login($usuario, $senha)){
    // Set session to last for at least one day (86400 seconds)
    ini_set('session.gc_maxlifetime', 86400);
    session_set_cookie_params(86400);
    session_start();
    $_SESSION['email_usuario'] = $usuario;
    $_SESSION['senha_usuario'] = $senha;
    $_SESSION['id_usuario'] = $l->get_user_id($usuario);
    $_SESSION['cidade_id'] = $l->login($usuario, $senha)['cidade_id'];
    $_SESSION['acesso'] = $l->login($usuario, $senha)['acesso'];
    header("Location: dash.php");
} else {
    echo '<script>alert("Usuário ou senha incorretos!");</script>';
    echo '<script>window.location.href="../painel/index.php";</script>';
}