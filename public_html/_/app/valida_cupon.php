<?php
header("Access-Control-Allow-Origin: *");
include '../classes/cupons.php';
include '../classes/tempo.php';
include '../classes/corridas.php';

$t = new Tempo();
$cupons = new cupons();
$c = new corridas();
$user_id = $_POST['user_id'];
if (isset($_POST['cupom']) && !empty($_POST['cupom']) && !empty($_POST['user_id']) && !empty($_POST['cidade_id'])) {
    $valor  = $_POST['valor'];
    $valor = str_replace(',', '.', $valor);
    $cupom = addslashes($_POST['cupom']);
    $dados_cupon = $cupons->get_cupon_nome($cupom, $_POST['cidade_id']);
    $usado = $cupons->verifica_cupon_used($_POST['cidade_id'], $cupom, $_POST['user_id']);
    $t->data_fim = $dados_cupon['validade'];
    $desconto = 0;
    $valor_min = $dados_cupon['valor_min'];
    $valor_min = str_replace(',', '.', $valor_min);

    $corridas_cliente = $c->get_all_corridas_cliente($user_id);
    if(count($corridas_cliente) > 0) {
        $ja_fez_corrida = true;
    } else {
        $ja_fez_corrida = false;
    }
    if ($t->tempo_passou() > 0) {
        $status =  "Cupom expirado";
    } else {
        if ($dados_cupon['quantidade'] <= 0) {
            $status =  "Cupom esgotado";
        } else {
            if ($usado && $dados_cupon['uso_unico'] == 1) {
                $status =  "Cupom já utilizado";
            } else {
                if ($valor_min > $valor) {
                    $status =  "Valor mínimo não atingido";
                } else {
                    if ($dados_cupon['primeira_compra'] == 1 && $ja_fez_corrida) {
                        $status =  "Cupon para Primeira Corrida";
                    } else {
                        $desconto_cupom = $dados_cupon['valor'];
                        $desconto_cupom = str_replace(',', '.', $desconto_cupom);
                        if ($dados_cupon['tipo_desconto'] == 2) {
                            $desconto = $valor - $desconto_cupom;
                        } else {
                            $desconto = $valor - ($valor * ($desconto_cupom / 100));
                        }
                        $status = "Cupom aplicado!";
                    }
                }
            }
        }
    }
    //limita desconto a duas casas decimais
    $desconto = number_format($desconto, 2, '.', '');
    echo json_encode(array('status' => $status, 'desconto' => $desconto));
}
