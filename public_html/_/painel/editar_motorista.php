<?php
include("seguranca.php");
include("nivel_acesso.php");
include("../classes/motoristas.php");
include("../classes/categorias.php");
include("../classes/motorista_docs.php"); // Incluindo a classe que modificamos
include("../classes/upload.php");
include("../classes/transacoes_motoristas.php");
include("../classes/franqueados.php");

$m = new motoristas();
$c = new categorias();
$md = new motorista_docs(); // Instanciando a classe que modificamos

// --- INÍCIO DO BLOCO DE PROCESSAMENTO ---
// Este código só executa quando o botão "Atualizar informações" é clicado

if (isset($_POST['btn_enviar'])) {
    $id_motorista = $_GET['id'];
    $dados = $m->get_motorista($id_motorista);
    $saldo_antigo = str_replace(",", ".", $dados['saldo']);
    
    $t = new transacoes_motoristas($cidade_id);
    $f = new franqueados();

    $franqueado_id = $_SESSION['id_usuario'];
    $franqueado = $f->get_usuario_id($franqueado_id);
    $limite_credito_motorista = $franqueado['limite_credito_motorista'];

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $veiculo = $_POST['veiculo'];
    $placa = $_POST['placa'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $taxa = $_POST['taxa'];
    $ids_categorias = $_POST['ids_categorias'];
    $email = $_POST['email'];
    $validade_cnh = $_POST['validade_cnh'];
    $validade_doc_veiculo = $_POST['validade_doc_veiculo'];
    $taxa_semanal = $_POST['taxa_semanal'];
    $saldo = str_replace(",", ".", $_POST['saldo']);
    $limite_credito = $_POST['limite_credito'];

    if ($limite_credito > $limite_credito_motorista) {
        echo "<script>alert('Limite de crédito não pode ser maior que o limite de crédito do franqueado que é de R$ $limite_credito_motorista');</script>";
        echo "<script>window.location.href='editar_motorista.php?id=$id_motorista';</script>";
        exit;
    } else {
        $m->updateLimiteCredito($id_motorista, $limite_credito);
    }

    if ($saldo_antigo < $saldo) {
        $valor_difereca = $saldo - $saldo_antigo;
        $valor_difereca = number_format($valor_difereca, 2, ',', '.');
        $t->insereTransacao($id_motorista, "", $valor_difereca, "CREDITO PLATAFORMA", "CONCLUIDO");
    } else if ($saldo_antigo > $saldo) {
        $valor_difereca = $saldo_antigo - $saldo;
        $valor_difereca = number_format($valor_difereca, 2, ',', '.');
        $t->insereTransacao($id_motorista, "", $valor_difereca, "DEBITO PLATAFORMA", "CONCLUIDO");
    }

    $pasta = '../admin/uploads/';
    $img = $_FILES['img'];
    if ($img['name'] != "") {
        $upload = new Upload($img, 800, 800, $pasta);
        $nome_img = $upload->salvar();
    } else {
        $nome_img = $dados['img'];
    }

    // ATUALIZA DADOS PRINCIPAIS
    $m->edit_motorista($id_motorista, $nome, $cpf, $nome_img, $veiculo, $placa, $telefone, $senha, $taxa, $saldo, $ids_categorias);
    $m->updateEmail($id_motorista, $email);
    $m->updateValidade_cnh($id_motorista, $validade_cnh);
    $m->updateValidadeDocVeiculo($id_motorista, $validade_doc_veiculo);
    $m->setTaxaSemanal($id_motorista, $taxa_semanal);

    // *** AQUI ESTÁ A NOSSA NOVA LÓGICA DE SINCRONIZAÇÃO SENDO CHAMADA ***
    $md->sincronizarDados($id_motorista, $nome, $veiculo, $placa);

    echo "<script>alert('Dados atualizados com sucesso!');</script>";

    $origem = $_POST['origem'];
    if ($origem == "lista_motoristas_temp") {
        echo "<script>window.location.href='lista_motoristas_temp.php';</script>";
    } else {
        echo "<script>window.location.href='listar_motoristas.php';</script>";
    }
    exit; // Importante para parar a execução após o processamento
}
// --- FIM DO BLOCO DE PROCESSAMENTO ---


// O restante do arquivo (a parte que busca os dados para exibir) continua aqui
$motorista_id = $_GET['id'];
$origem = $_GET['origem'] ?? "";
$dados_motorista = $m->get_motorista($motorista_id);
$categorias = $c->get_categorias($cidade_id);
?>
<!doctype html>
<html lang="pt-br">
<?php include "head.php"; ?>
<?php include("menu.php"); ?>

<body>
    <div class="container-fluid">
    </div>
    <div class="container">
        <div class="container-principal-produtos">
            <h4 class="page-header">EDITAR INFORMAÇÕES DO MOTORISTA</h4>
            <hr>
            <!-- **** CORREÇÃO CRUCIAL AQUI: O 'action' do formulário foi corrigido **** -->
            <form action="editar_motorista.php?id=<?php echo $motorista_id; ?>" method="POST" enctype="multipart/form-data" name="upload">
                <div class="row">
                    <input type="hidden" name="origem" value="<?php echo $origem; ?>">
                </div>
                <!-- O restante do seu formulário HTML permanece exatamente o mesmo -->
                <div class="row">
					<div class="form-group col-md-8">
						<!--Realizando Upload de Imagem-->
						<label class="control-label">Foto do Motorista</label>
						<input class="form-control" type="file" name="img">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						<label>Nome do motorista:</label>
						<input class="form-control form-control-sm col-md-09 col-sm-09" value="<?php echo $dados_motorista['nome']; ?>" type="text" name="nome" placeholder="Nome" />
						</br>
						<label>Telefone:</label>
						<input class="form-control form-control-sm col-md-09 col-sm-09" value="<?php echo $dados_motorista['telefone']; ?>" type="text" name="telefone" placeholder="Telefone" />
						</br>
						<label>Email:</label>
						<input class="form-control form-control-sm col-md-09 col-sm-09" value="<?php echo $dados_motorista['email']; ?>" type="email" name="email" placeholder="Email" />
						</br>
						<label>CPF do motorista:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="text" value="<?php echo $dados_motorista['cpf']; ?>" name="cpf" placeholder="CPF" />
						<br>
						<label>Senha para acesso do motorista:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="text" value="<?php echo $dados_motorista['senha']; ?>" name="senha" placeholder="Senha" />
						<br>
						<label>Veículo do motorista:</label>
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="text" value="<?php echo $dados_motorista['veiculo']; ?>" name="veiculo" placeholder="Ex: Gol 2015 branco" />
						<br>
						<label>Placa do veículo:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="text" value="<?php echo $dados_motorista['placa']; ?>" name="placa" placeholder="Placa" />
						<br>
						<label>Validade da Habilitação:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="date" value="<?php echo $dados_motorista['validade_cnh']; ?>" name="validade_cnh" placeholder="Validade da Habilitação" />
						<br>
						<label>Validade Documento Veículo:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="date" value="<?php echo $dados_motorista['validade_doc_veiculo']; ?>" name="validade_doc_veiculo" placeholder="Validade Documento Veículo" />
						<br>
						<label>Taxa a cobrar em porcentagem:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="text" value="<?php echo $dados_motorista['taxa']; ?>" name="taxa" placeholder="Taxa" />
						<br>
						<label>Saldo:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="text" value="<?php echo $dados_motorista['saldo']; ?>" name="saldo" placeholder="Saldo" />
						<br>
						<label>Limite de Crédito:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="number" value="<?php echo $dados_motorista['limite_credito']; ?>" name="limite_credito" placeholder="Limite de Crédito" />
						<br>
						<!-- taxa_semanal -->
						<label>Taxa Semanal:</label>&nbsp
						<input class="form-control form-control-sm col-md-09 col-sm-09" type="text" value="<?php echo $dados_motorista['taxa_semanal']; ?>" name="taxa_semanal" placeholder="Taxa Semanal" />
						<br>
						<div class="row">
							<div class="form-group col-md-4">
								<label>Categorias:</label>
								<div style="border: solid; width: 100%; padding-left: 10px;  height: 100px; background-color: #f5f5f5; border-color: gray; border-radius: 5px; overflow-y: scroll;">
								<?php	
								$ids_categorias = json_decode($dados_motorista['ids_categorias']);
									if ($ids_categorias === NULL) {
									$ids_categorias = array();
									}
									foreach ($categorias as $c) {
									$checked = "";
									if (in_array($c['id'], $ids_categorias)) {
									$checked = "checked";
									}
									echo '<input type="checkbox" name="ids_categorias[]" value="' . $c['id'] . '" ' . $checked . '> ' . $c['nome'] . '<br>';
									}
								?>
								</div>

							</div>
						</div>
						<input type="submit" class="btn btn-primary" name="btn_enviar" value="Atualizar informações">
						<hr>
				</form>
            </div>
        </div><!--Fechando container bootstrap-->
    <?php include("dep_query.php"); ?>

</body>

</html>

<script>
	var data = new Date();
		var dia = data.getDate();
		if(dia < 10){
			dia = '0'+dia;
		}
		var mes = data.getMonth();
		mes = mes + 1;
		if(mes < 10){
			mes = '0'+mes;
		}
		var ano = data.getFullYear();
	//quando validade_cnh muda, verificar se é menor que a data atual se for exibir alerta e redefine o input
	$('input[name="validade_cnh"]').change(function() {
		var data_atual = ano + '-' + mes + '-' + dia;
		console.log("data atual" + data_atual);
		var validade_cnh = $('input[name="validade_cnh"]').val();
		console.log(validade_cnh);
		if (validade_cnh < data_atual) {
			alert("Data inválida, por favor insira uma data válida!");
			$('input[name="validade_cnh"]').val("");
		}
	});

	$('input[name="validade_doc_veiculo"]').change(function() {
		var data_atual = ano + '-' + mes + '-' + dia;
		console.log("data atual" + data_atual);
		var validade_doc_veiculo = $('input[name="validade_doc_veiculo"]').val();
		console.log(validade_doc_veiculo);
		if (validade_doc_veiculo < data_atual) {
			alert("Data inválida, por favor insira uma data válida!");
			$('input[name="validade_doc_veiculo"]').val("");
		}
	});
</script>
