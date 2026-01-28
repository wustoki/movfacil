<?php include_once 'seguranca.php'; ?>
<style>
  /* Seus estilos personalizados aqui */
  /* Exemplo de estilo para o menu principal */
  .navbar {
    background-color: #153DA1;
  }
  .navbar-toggler-icon {
    background-color: white;
  }
  .navbar-brand img {
    width: 150px;
  }
  .navbar-nav .nav-item .nav-link {
    color: white;
    transition: color 0.3s;
  }
  .navbar-nav .nav-item .nav-link:hover {
    color: #ff9900;
  }
  /* Estilo para os itens do menu dropdown */
  .dropdown-menu {
    background-color: #153DA1;
    border: none;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  .dropdown-item {
    color: white;
    transition: background-color 0.3s;
  }
  .dropdown-item:hover {
    background-color: #ff9900;
  }
  .navbar-toggler-icon {
    background-color: #153DA1;
    /* Mude para a cor desejada */
  }
</style>
<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="dash.php">
    <img src="../assets/img/logo.png" alt="Logo">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="dash.php">Início<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="corridas.php">Corridas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="novo_chamado.php">Novo Chamado</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="novo_push.php">Enviar Notificação Push</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="historico.php">Histórico</a>
      </li>
      <?php if ($admin == 1) { ?>
        <li class="nav-item">
          <a class="nav-link" href="cidades.php">Cidades</a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="franqueados.php">Franqueados</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownRelatorios" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Relatórios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownRelatorios">
          <a class="dropdown-item" href="relatorio_resumido.php">Relatório Resumido</a>
          <a class="dropdown-item" href="relatorio_semanal.php">Relatório Semanal</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- alertas e notificacoes -->
      <li class="nav-item">
        <a id="menu-alertas" class="nav-link" href="#" data-toggle="modal" data-target="#modalAlertas">
          <i class="bi bi-bell"></i>
        </a>
      <li class="nav-item">
        <a class="nav-link" href="destruirSessao.php">Sair</a>
      </li>
    </ul>
  </div>
</nav> 

<!-- modal de alertas e notificaçoes -->
<div class="modal fade" id="modalAlertas" tabindex="-1" role="dialog" aria-labelledby="modalAlertas" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAlertasTitle">Alertas e Notificações</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalAlertasBody">
                <ul class="list-group list-group-flush">
                    <!-- alertas e notificações serão inseridos aqui -->
                </ul>
            </div>
            <div class="modal-footer">
                <!-- botão limpar alertas -->
                <button type="button" id="limpar_alertas" onclick="limparAlertas()" class="btn btn-danger">
                    <i class="bi bi-trash"></i>
                    Limpar Alertas</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>

<script>
  // busca alertas e preenche modal
  let url_alertas = "<?php echo DOMINIO; ?>/_/funcoes/get_notificacoes.php";
  let cidade_id = <?php echo $cidade_id; ?>;
  //pega o last_id do último alerta salvo no localStorage
  let last_id = localStorage.getItem("last_id_admin");
  if (last_id === null) {
    last_id = 0;
  }
  // cria uma instância do objeto XMLHttpRequest
  let xhr = new XMLHttpRequest();
  // configura a requisição
  xhr.open("POST", url_alertas, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  // define a função a ser executada quando a requisição for concluída
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let alertas = JSON.parse(xhr.responseText);
      let alertas_html = "";
      alertas.forEach(alerta => {
        alertas_html += `<li class="list-group-item">${alerta.conteudo}</li>`;
        if (alerta.id > last_id) {
          last_id = alerta.id;
        }
      });
      //se a quantidade de alertas for 0, exibe uma mensagem
      if (alertas.length === 0) {
        alertas_html = "<li class='list-group-item'>Nenhum alerta ou notificação</li>";
      }
      document.getElementById("modalAlertasBody").innerHTML = alertas_html;
      //adiciona um badge com o número de alertas no menu-alertas do navbar
      if (alertas.length === 0) {
        document.getElementById("menu-alertas").innerHTML += `<span class="badge badge-success">${alertas.length}</span>`;
      } else {
        document.getElementById("menu-alertas").innerHTML += `<span class="badge badge-danger">${alertas.length}</span>`;
      }
    }
  };
  // envia a requisição
  xhr.send("cidade_id=" + cidade_id + "&last_id=" + last_id);


  // limpa alertas
  function limparAlertas() {
    localStorage.setItem("last_id_admin", last_id);
    document.getElementById("modalAlertasBody").innerHTML = "";
    //reload da página
    location.reload();
  }
</script>
