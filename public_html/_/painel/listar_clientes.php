<?php
include("seguranca.php");
include("../classes/franqueados.php");
include("../classes/clientes.php");
include("../classes/avaliacoes.php");
include("../classes/cancelamentos.php");
$f = new franqueados();
$c = new clientes();
$a = new avaliacoes();
$canc = new cancelamentos();
$lista_clientes = $c->get_clientes_cidade($cidade_id);
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
      <div class="row">
        <div class="col-md-6">
          <h4 class="page-header">Lista de Clientes</h4>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <th>ID</th>
              <th>Nome</th>
              <th>Telefone</th>
              <th>CPF</th>
              <th>Avaliação</th>
              <th>Desempenho</th>
              <th>Ações</th>
              <th>Status</th>
            </thead>
            <tbody>
              <?php
              foreach ($lista_clientes as $linha) {
                $desempenho = $canc->getTaxaCancelamentoCliente($linha['id']);
                //converte para inteiro
                $desempenho = intval($desempenho);
                $nota = $a->get_media_avaliacoes_cliente($linha['id']);
                if($nota == 0){
                  $nota = 'Sem avaliações';
                }
                //coloca duas casas decimais
                $nota = number_format($nota, 2, '.', '');
                echo '<tr>';
                echo  '<td>' . $linha['id'] . '</td>';
                echo  '<td>' . $linha['nome'] . '</td>';
                echo  '<td>' . $linha['telefone'] . '</td>';
                echo  '<td>' . $linha['cpf'] . '</td>';
                echo  '<td>' . $nota . '</td>';
                echo  '<td>' . $desempenho . '%</td>';
                //Ações 
                echo "<td><a class='btn btn-info' href='avaliacoes.php?id=$linha[id]&pessoa=cliente' role='button'><i class='bi bi-star-half'></i></a>&nbsp";                                   
                echo "<button type='button' class='btn btn-info'  data-toggle='modal' data-target='#myModal$linha[id]'><i class='bi bi-eye'></i></button>&nbsp";
                echo "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#editar$linha[id]' data-whatever='{$linha['id']}' role='button'><i class='bi bi-pencil'></i></button>&nbsp";
                echo "</td>";
                if ($linha['ativo'] == '1') {
                  echo "<td><a class='btn btn-outline-success' href='desativar_cliente.php?id=$linha[id]&ativo=2' role='button'>Ativo</a>&nbsp</td>";
                } else {
                  echo "<td><a class='btn btn-outline-danger' href='desativar_cliente.php?id=$linha[id]&ativo=1' role='button'>Bloqueado</a>&nbsp</td>";
                }


                echo "</tr>";
              ?>
                <!--Inicio Modal.-->
                <div class="modal fade" id="myModal<?php echo $linha['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <center>
                          <h3 class="modal-title" id="myModalLabel"> Cliente: <?php echo $linha['nome']; ?></h3>
                        </center>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                      <div class="modal-body">
                        <br>
                        <b>Nome: </b><?php echo $linha['nome']; ?><br>
                        <b>Telefone: </b><?php echo $linha['telefone']; ?><br>
                        <b>CPF: </b><?php echo $linha['cpf']; ?><br>
                        <b>Email: </b><?php echo $linha['email']; ?><br>
                        <b>Saldo: </b><?php echo $linha['saldo']; ?><br>
                        <hr>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!--fim modal-->
                <!--modal editar-->
                <div class="modal fade" id="editar<?php echo $linha['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editar" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <form action="edit_cliente.php?id=<?php echo $linha['id']; ?>" method="POST" enctype="multipart/form-data" name="upload">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editar">Editar Cadastro <?php echo $linha['nome']; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <!-- nome -->
                          <div class="row">
                            <div class="form-group col-md-12">
                              <label>Nome do cliente</label>
                              <input class="form-control form-control-sm col-md-09 col-sm-09" type="text" id="nome" required name="nome" placeholder="Nome do cliente" value="<?php echo $linha['nome']; ?>" />
                            </div>
                          </div>
                          <!-- telefone -->
                          <div class="row">
                            <div class="form-group col-md-12">
                              <label>Telefone:</label>
                              <input class="form-control form-control-sm col-md-06 col-sm-06" id="telefone" type="number" required name="telefone" placeholder="ex: 066999395555" value="<?php echo $linha['telefone']; ?>" />
                            </div>
                          </div>
                          <!-- cpf -->
                          <div class="row">
                            <div class="form-group
                            col-md-12">
                              <label>CPF:</label>
                              <input class="form-control form-control-sm col-md-06 col-sm-06" id="cpf" type="text" required name="cpf" placeholder="ex: 000.000.000-00" value="<?php echo $linha['cpf']; ?>" />
                            </div>
                          </div>
                          <!-- email -->
                          <div class="row">
                            <div class="form-group
                            col-md-12">
                              <label>Email:</label>
                              <input class="form-control form-control-sm col-md-06 col-sm-06" id="email" type="email" required name="email" placeholder="ex: teste@teste" value="<?php echo $linha['email']; ?>" />
                            </div>
                          </div>
                          <!-- saldo -->
                          <div class="row">
                          <div class="form-group col-md-12">
                              <label>Saldo:</label>
                              <input class="form-control form-control-sm col-md-06 col-sm-06" id="saldo" type="number" required name="saldo" placeholder="ex: 50,00" value="<?php echo $linha['saldo']; ?>" />
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!--modal editar-->
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!--Fechando container bootstrap-->
    <?php include("dep_query.php"); ?>
</body>

</html>

<script>

</script>