<?php
$ano = date("Y");
?>
<style>
  /* Exemplo de estilo para o menu principal */
  .navbar {
    background-color: #16537e;
  }

  .navbar-toggler-icon {
    background-color: white;
  }

  .navbar-brand img {
    width: 100px;
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
    background-color: #16537e;
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

  .list-group-item {
    cursor: pointer;
  }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="corridas.php">
    <img src="../assets/img/logo.png" alt="Logo">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a id="menu-controle" class="nav-link" href="dash.php">Dashboard</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="menu-corridas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Corridas
        </a>
        <div class="dropdown-menu" aria-labelledby="menu-corridas">
          <a class="dropdown-item" style="color: white;" href="novo_chamado.php">Novo Chamado</a>
          <a class="dropdown-item" style="color: white;" href="corridas.php">Corridas</a>
          <a class="dropdown-item" style="color: white;" href="denuncias.php">Denúncias</a>
        </div>
      </li>


      <li class="nav-item">
        <a id="menu-historico" class="nav-link" href="historico.php">Histórico</a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="menu-corridas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Locações
        </a>
        <div class="dropdown-menu" aria-labelledby="menu-corridas">
        <a class="dropdown-item" style="color: white;" href="veiculos.php">Veículos</a>
          <a class="dropdown-item" style="color: white;" href="relatorio_locacoes.php">Relatório de Locações</a>
          <a class="dropdown-item" style="color: white;" href="divisao_locacoes.php">Divisão de Faturamento</a>
        </div>
      </li>

      <!-- Insert the dropdown menu for Motoristas here -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="menu-motoristas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Motoristas
        </a>
        <div class="dropdown-menu" aria-labelledby="menu-motoristas">
          <a class="dropdown-item" style="color: white;" href="cadastra_motorista.php">Cadastro de Motoristas</a>
          <a class="dropdown-item" style="color: white;" href="listar_motoristas.php">Motoristas Ativos</a>
          <a class="dropdown-item" style="color: white;" href="listar_motoristas_off.php">Motoristas Desativados</a>
          <a class="dropdown-item" style="color: white;" href="relatorio_motoristas.php">Relatório Motoristas</a>
          <a class="dropdown-item" style="color: white;" href="fechamento_semana.php">Relatório Semanal</a>
          <a class="dropdown-item" style="color: white;" href="lista_motoristas_temp.php">Motoristas aguardando aprovação</a>
          <a class="dropdown-item" style="color: white;" href="transacoes_motoristas.php">Transações</a>
        </div>
      </li>
      <!-- Insert the dropdown menu for Clientes here -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="menu-clientes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Clientes
        </a>
        <div class="dropdown-menu" aria-labelledby="menu-clientes">
          <a class="dropdown-item" style="color: white;" href="listar_clientes.php">Clientes</a>
          <a class="dropdown-item" style="color: white;" href="transacoes.php">Transações</a>
        </div>
      </li>
      <li class="nav-item">
        <a id="menu-historico" class="nav-link" href="listar_cupons.php">Cupons</a>
      </li>

      <li class="nav-item">
        <a id="menu-relatorio-geral" class="nav-link" href="categorias.php">Categorias</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="menu-clientes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dinâmico
        </a>
        <div class="dropdown-menu" aria-labelledby="menu-clientes">
          <a class="dropdown-item" style="color: white;" href="dinamico_horario.php">Por Horário</a>
          <a class="dropdown-item" style="color: white;" href="dinamico_mapa.php">Por Região</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="menu-clientes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Configurações
        </a>
        <div class="dropdown-menu" aria-labelledby="menu-clientes">
          <a class="dropdown-item" style="color: white;" href="configuracoes_pagamento.php">Configurações de Pagamento</a>
        </div>
      </li>
      <li class="nav-item">
        <a id="menu-relatorio-geral" class="nav-link" href="compartilhamentos.php">Compartilhamentos</a>
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
  let last_id = localStorage.getItem("last_id");
  if (last_id === null) {
    last_id = 0;
  }
  //transforma last_id em número
  last_id = parseInt(last_id);
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
        alertas_html += `<li class="list-group-item"><a href="${alerta.link}">${alerta.conteudo}</a></li>`;
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
    localStorage.setItem("last_id", last_id);
    document.getElementById("modalAlertasBody").innerHTML = "";
    //reload da página
    location.reload();
  }
</script>