<?php
//acessos diferentes de nível 1 e 3 não podem acessar a página
if($_SESSION['acesso'] != 1 && $_SESSION['acesso'] != 3){
    //exibe mensagem de erro e retorna para a página anterior
    echo '<script>alert("Você não tem permissão para acessar esta página!");</script>';
    echo '<script>window.location.href="javascript:history.back()";</script>';
    exit;
}