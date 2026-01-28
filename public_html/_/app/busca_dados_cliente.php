<?php //copia login user.php para tela home
header('access-control-allow-origin: *');
include_once "../classes/clientes.php";
include_once "../classes/avaliacoes.php";
include_once "../classes/cancelamentos.php";
include_once "../classes/corridas.php";
$clientes = new Clientes();
$a = new avaliacoes();
$c = new cancelamentos();
$cor = new corridas();
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];

$salt = "anjdsn5s141d5";
$senha = md5($senha.$salt);

$cliente = $clientes->verifica_se_existe($telefone);

if($cliente){
    if($cliente['senha'] == $senha){
        $cliente_id = $cliente['id'];
        $performance = $c ->getTaxaCancelamentoCliente($cliente_id);
        //to int
        $performance = intval($performance);
        $n_corridas = $cor->getTotalCorridasCliente($cliente_id);
        $nota = $a->get_media_avaliacoes_cliente($cliente_id);
        if($nota == null){
            $nota = 0;
        }
        //duas casas decimais
        $nota = number_format($nota, 2, '.', '');

        $retorno = array(
            "status" => "sucesso",
            "id" => $cliente['id'],
            "nome" => $cliente['nome'],
            "telefone" => $cliente['telefone'],
            "ativo" => $cliente['ativo'],
            "saldo" => $cliente['saldo'],
            "cidade_id" => $cliente['cidade_id'],
            "ref_cliente" => $cliente['ref_cliente'],
            "nota" => $nota,
            "performance" => $performance,
            "n_corridas" => $n_corridas
        );
    } else {
        $retorno = array(
            "status" => "erro",
            "erro" => "Telefone ou senha incorretos"
        );
    }
} else {
    $retorno = array(
        "status" => "erro",
        "erro" => "Telefone ou senha incorretos"
    );
}

echo json_encode($retorno);