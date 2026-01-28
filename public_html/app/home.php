<!DOCTYPE html>
<html lang="pt-br">

<head><meta charset="utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#000000">
  <title>MovFacil</title>
  <!-- bootstrap css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- bootstrap icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <!-- sweetalert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--material icons-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="manifest" href="manifest.json">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="BootBlocks">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="msapplication-starturl" content="index.php">
  <link rel="icon" sizes="192x192" href="assets/icon-192x192.png">
  <link rel="apple-touch-icon" href="assets/icon-192x192.png">
  <link rel="shortcut icon" href="assets/icon-192x192.png">
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-M2J2KJ96');
  </script>
  <!-- End Google Tag Manager -->
  <script>
    var onesignal_user_id = "";
    var OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
      OneSignal.init({
        appId: "6f8db040-fda6-4d3d-bf27-26782e2978d2",
      });
      OneSignal.getUserId(function(userId) {
        onesignal_user_id = userId;
      });
    });
  </script>
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M2J2KJ96"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div id="loading-page-bb" style="opacity: 0; height: 100%;">


    <!-- selecionar destino -->
    <div id="tela_destinos" class="classe_da_tela" style="background-color: #ffffff; height: 100%; width: 100%;">
      <div class="container" id="id_do_container">
        <div id="destinos_cabecalho" class="classe_da_tela" style="background-color: #ffffff; height: 50px; width: 100%;">
          <span class="material-icons" id="icone_voltar_destinos" style="font-size:25px; color:#000000;">arrow_back</span>
          <div id="tela_lbl_destino" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 80%;">
            <span class="meu_texto" id="lbl_selecionar_destino" style="font-size: 16px; color: #2110e0;  ">Selecionar Destino</span>
          </div>
        </div>

        <div class="d-flex align-items-center">
          <input type="text" class="form-control" id="box_origem" placeholder="Partida">
          <span class="material-icons ms-2" id="icone_favorito_origem" style="font-size:24px; color:#000000; cursor:pointer;">star</span>
        </div>
        <div style="width:10px;height:10px;"></div>
        <input type="text" class="form-control" id="box_destino" placeholder="Destino">
        <div style="width:10px;height:10px;"></div>
        <!-- select historico -->
        <div id="div_historico" class="form-group" style="display:none;">
          <label class="mb-2" for="exampleFormControlSelect1">Histórico de Destinos</label>
          <select class="form-control" id="historico_destinos" style="border-radius: 15px;">
            <option value="">Selecione</option>
          </select>
        </div>
        <div style="width:10px;height:20px;"></div>
        <span class="meu_texto" id="lbl_informe_usuarios" style="font-size: 16px; color: #000000;  ">Selecione quantos passageiros: (Obrigatório)</span>
        <div style="width:10px;height:10px;"></div>
        <div id="tela_qnt_usuarios" class="classe_da_tela" style="background-color: #ffffff; height: 40px; width: 100%;">
          <span class="material-icons" id="icone_remove" style="font-size:24px; color:#000000;">remove</span>
          <input type="text" class="form-control" id="box_qnt_passageiros" placeholder="0">
          <span class="material-icons" id="icone_add" style="font-size:24px; color:#000000;">add</span>
        </div>
      </div>
    </div>
    <!-- selecionar destino -->

    <!-- modal para exibir o endereço de casa e a opção de usar ou deletar -->
    <div class="modal fade" id="modal_favorito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Endereço de Casa</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container" id="id_do_container">
              <span class="meu_texto" id="txt_favorito" style="font-size: 16px; color: #000000;  "></span>
            </div>
          </div>
          <div class="modal-footer">
            <!-- botão salvar -->
            <button type="button" onclick="salvar_favorito()" id="salvar_favorito_btn" class="btn btn-primary"><i class="bi bi-save"></i> Salvar</button>
            <button type="button" onclick="usar_favorito()" id="usar_favorito_btn" class="btn btn-primary"><i class="bi bi-check-circle"></i> Usar</button>
            <button type="button" onclick="deletar_favorito()" id="deletar_favorito_btn" class="btn btn-danger"><i class="bi bi-trash"></i> Deletar</button>
          </div>
        </div>
      </div>
    </div>



    <div class="modal fade" id="modal_ajuda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajuda</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container" id="id_do_container">
              <span class="meu_texto" id="lbl_aj" style="font-size: 16px; color: #000000;  ">Selecione:</span>
              <div style="width:10px;height:10px;"></div>
              <button type="button" onclick="problema_viagem()" id="btn_problema_viagem" class="btn btn-warning">Problema com Viagem</button>
              <div style="width:10px;height:10px;"></div>
              <button type="button" onclick="problema_aplicativo()" id="btn_problema_aplicativo" class="btn btn-danger">Problema com Aplicativo</button>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>



    <div class="modal fade" id="modal_avaliar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Avaliação da Corrida</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container" id="id_do_container">
              <span class="meu_texto" id="lbl_avaliar" style="font-size: 16px; color: #000000;  ">Que nota você dá para a sua última corrida?</span>
              <div style="width:10px;height:10px;"></div>
              <div class="row justify-content-around" id="Linha">
                <div class="col-2">
                  <img src="assets/estrela_cinza.png" height="25px" width="25px" id="estrela_1">
                </div>
                <div class="col-2">
                  <img src="assets/estrela_cinza.png" height="25px" width="25px" id="estrela_2">
                </div>
                <div class="col-2">
                  <img src="assets/estrela_cinza.png" height="25px" width="25px" id="estrela_3">
                </div>
                <div class="col-2">
                  <img src="assets/estrela_cinza.png" height="25px" width="25px" id="estrela_4">
                </div>
                <div class="col-2">
                  <img src="assets/estrela_cinza.png" height="25px" width="25px" id="estrela_5">
                </div>
              </div>
              <div style="width:10px;height:20px;"></div>
              <input type="text" class="form-control" id="avaliacao_txt" placeholder="Escreva um comentário..">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="enviar_avaliacao()" id="avaliar_btn" class="btn btn-success">Enviar Avaliação</button>
          </div>
        </div>
      </div>
    </div>



    <audio id="audio" src="assets/toque_status.mp3" controls></audio>
    <audio id="audio_message" src="assets/messenger.mp3" controls></audio>



    <div id="tela_status" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
      <div id="tela_cabecalho_status" class="classe_da_tela" style="background-color: #ffffff; height: 50px; width: 100%;">
        <div style="width:90%;height:10px;"></div>
        <span class="material-icons" id="icone_minimizar" style="font-size:27px; color:#333333;">close_fullscreen</span>
      </div>
      <div id="tela_img_motorista" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <img src="" style="height: 100px; width: 100px;" id="img_motorista">
      </div>
      <div id="tela_dados_motorista" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="dados_motorista" style="font-size: 16px; color: #000000;  "></span>
        <div style="width:10px;height:10px;"></div>
      </div>
      <div id="tela_lottie" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <!-- Reprodutor Lottie -->
        <lottie-player id="reprodutor_lottie_1" src="assets/procurando.json" background="transparent" speed="1" style="width: 200px; height: 100px" direction="1" autoplay mode="normal" loop></lottie-player>
        <!-- Reprodutor Lottie -->
        <lottie-player id="reprodutor_lottie_2" src="assets/em_andamento.json" background="transparent" speed="1" style="width: 250px; height: 150px" direction="1" autoplay mode="normal" loop></lottie-player>
        <!-- Reprodutor Lottie -->
        <lottie-player id="reprodutor_lottie_3" src="assets/finalizada.json" background="transparent" speed="1" style="width: 250px; height: 150px" direction="1" autoplay mode="normal" loop></lottie-player>
        <!-- Reprodutor Lottie -->
        <lottie-player id="reprodutor_lottie_4" src="assets/cancelada.json" background="transparent" speed="1" style="width: 250px; height: 150px" direction="1" autoplay mode="normal" loop></lottie-player>
      </div>
      <div id="tela_status_txt" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="txt_status" style="font-size: 18px; color: #333333; font-weight: bold; ">Procurando Motorista</span>
      </div>
      <div style="width:10px;height:10px;"></div>
      <div id="tela_timer" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="txt_timer" style="font-size: 30px; color: #333333; font-weight: bold; ">0:00</span>
      </div>
      <div style="width:10px;height:10px;"></div>
      <div id="tela_txt_finalizar" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="txt_total_fim" style="font-size: 16px; color: #000000;  "></span>
      </div>
      <div id="tela_botoes_status" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <div class="meu_card" id="card_cancelar" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);">
          <span class="meu_texto" id="txt_cancelar" style="font-size: 18px; color: #ffffff; font-weight: bold; ">Cancelar Corrida</span>
        </div>
        <div class="meu_card" id="card_finalizar" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);">
          <span class="meu_texto" id="txt_finalizar" style="font-size: 18px; color: #ffffff; font-weight: bold; ">Finalizar Corrida</span>
        </div>
      </div>
      <div style="width:10px;height:10px;"></div>
    </div>



    <div class="modal fade" id="modal_dados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Meus Dados</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container" id="id_do_container">
              <span class="meu_texto" id="txt_nome_telefone_dados" style="font-size: 16px; color: #000000;  "></span>
              <div style="width:10px;height:15px;"></div>
              <span class="meu_texto" id="altera_senha" style="font-size: 17px; color: #000000; font-weight: bold; "><?php echo "<span style='color:#000099;'>" . '<br> Alterar Senha:' . "</span>"; ?></span>
              <input type="text" class="form-control" id="dados_senha_1" placeholder="Nova Senha">
              <div style="width:10px;height:10px;"></div>
              <input type="text" class="form-control" id="dados_senha_2" placeholder="Repita Nova Senha">
              <div style="width:10px;height:10px;"></div>
              <button type="button" onclick="alterar_senha()" id="btn_alterar_senha" class="btn btn-primary">Alterar Senha</button>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="fechar_modal_dados()" id="btn_fechar_modal_dados" class="btn btn-secondary">Fechar</button>
          </div>
        </div>
      </div>
    </div>



    <div class="modal fade" id="modal_contato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Contato</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container" id="id_do_container">
              <span class="meu_texto" id="txt_contato" style="font-size: 16px; color: #000000;  "></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="fechar_modal()" id="fechar_modal_btn" class="btn btn-secondary">Fechar</button>
            <button type="button" onclick="enviar_whats_contato()" id="whats_btn" class="btn btn-success">Whatsapp</button>
          </div>
        </div>
      </div>
    </div>


    <?php
    ?>


    <div id="tela_menu" class="classe_da_tela" style="background-color: #ffffff; height: 100%; width: 100%;">
      <div class="container" id="container_menu">
        <div style="width:10px;height:100px;"></div>
        <div id="cabecalho_menu" class="classe_da_tela" style="background-color: #ffffff; height: 150px; width: 100%;">
          <span class="meu_texto" id="lbl_nome_cliente_menu" style="font-size: 20px; color: #000000; font-weight: bold; "></span>
          <span class="meu_texto" id="lbl_avaliacaoo" style="font-size: 20px; color: #000000; font-weight: bold; "><br> Avaliação: </span>
          <span class="meu_texto" id="lbl_avaliacao" style="font-size: 20px; color: #000000; font-weight: bold; "></span>
          <span class="meu_texto" id="lbl_performance" style="font-size: 16px; color: #000000;  "></span>
          <span class="meu_texto" id="lbl_total_corridas" style="font-size: 16px; color: #000000;  "></span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_carteira_credito" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_carteira_credito" style="font-size:24px; color:#000000;">account_balance_wallet</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_crt_credito" style="font-size: 18px; color: #000000;  ">Carteira de Crédito</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <!-- entregas -->
        <div id="tela_entregas" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_entregas" style="font-size:24px; color:#000000;">local_shipping</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_entregas" style="font-size: 18px; color: #000000;  ">Entregas</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_meus_dados" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_meus_dados" style="font-size:24px; color:#000000;">manage_accounts</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_meus_dados" style="font-size: 18px; color: #000000;  ">Meus Dados</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_historico_corridas" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_historico_corridas" style="font-size:24px; color:#000000;">history</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_historico_corridas" style="font-size: 18px; color: #000000;  ">Histórico de Corridas</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_download_app_motorista" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_download_motorista" style="font-size:24px; color:#000000;">download</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_download_motorista" style="font-size: 18px; color: #000000;  ">Aplicativo Motorista</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_ajuda" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_ajuda" style="font-size:24px; color:#000000;">help</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_ajuda" style="font-size: 18px; color: #000000;  ">Ajuda</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_fale_conosco" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_fale_conosco" style="font-size:24px; color:#000000;">call</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_fale_conosco" style="font-size: 18px; color: #000000;  ">Fale Conosco</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <!-- locação de veículos -->
        <div id="tela_locacao_veiculos" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%; display: flex; flex-direction: row; align-items: center;">
          <span class="material-icons" id="icone_locacao_veiculos" style="font-size:24px; color:#000000;">directions_car</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_locacao_veiculos" style="font-size: 18px; color: #000000;  ">Locação de Veículos</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_site" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_site" style="font-size:24px; color:#000000;">language</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_site" style="font-size: 18px; color: #000000;  ">Site</span>
        </div>
        <div style="width:10px;height:15px;"></div>
        <div id="tela_sair" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <span class="material-icons" id="icone_sair" style="font-size:24px; color:#000000;">logout</span>
          <div style="width:10px;height:1px;"></div>
          <span class="meu_texto" id="lbl_sair" style="font-size: 18px; color: #000000;  ">Sair</span>
        </div>
      </div>
    </div>



    <div id="cabecalho" class="classe_da_tela" style="background-color: #ffffff; height: 50px; width: 100%;">
      <div id="tela_icone_menu" class="classe_da_tela" style="background-color: #3333ff; height: auto; width: 10%;">
        <span class="material-icons" id="icone_menu" style="font-size:27px; color:#ffffff;">menu</span>
      </div>
      <div id="tela_label_cabecalho" class="classe_da_tela" style="background-color: #3333ff; height: auto; width: 90%;">
        <span class="meu_texto" id="txt_cabecalho" style="font-size: 20px; color: #ffffff; font-weight: bold; ">MovFacil</span>
      </div>
      <div id="tela_icone_chat" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 10%;">
        <span class="material-icons" id="icone_chat" style="font-size:27px; color:#ffffff;">chat</span>
      </div>
    </div>



    <div id="tela_mapa" class="classe_da_tela" style="background-color: #ffffff; height: 100%; width: 100%;">
    </div>



    <div id="tela_barra_inicio" class="classe_da_tela" style="background-color: #ffffff; height: 10%; width: 100%;">
      <div id="tela_boas_vindas" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="lbl_boas_vindas" style="font-size: 17px; color: #000000; font-weight: bold; "></span>
      </div>
      <div id="tela_onde_vamos" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="lbl_onde_vamos" style="font-size: 10px; color: #333333;  ">Para onde vamos?</span>
      </div>
      <div style="width:10px;height:10px;"></div>
      <div id="tela_card_iniciar" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <div class="meu_card" id="card_iniciar" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 10px 7px 13px 0px rgba(50, 50, 50, 0.22);">
          <span class="meu_texto" id="lbl_onde_card_iniciar" style="font-size: 16px; color: #ffffff; font-weight: bold; ">Escolher Destino</span>
          <span class="material-icons" id="icone_arrow" style="font-size:24px; color:#ffffff;">arrow_outward</span>
        </div>
      </div>
    </div>



    <div id="tela_categorias" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
      <div id="tela_cabecalho_categorias" class="classe_da_tela" style="background-color:#ffffff; height: 50px; width: 100%;">
        <div id="tela_lbl_categoria" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <div class="container" id="id_do_container">
            <span class="meu_texto" id="txt_tela_categorias" style="font-size: 16px; color:#05050a; font-weight: bold; ">Escolha o tipo de viagem:</span>
          </div>
        </div>
        <span class="material-icons" id="icone_minimizar_categorias" style="font-size:27px; color:#333333;">close_fullscreen</span>
      </div>
      <div id="tela_lista_categorias" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
      </div>
      <div style="width:10px;height:10px;"></div>
      <div class="container" id="id_do_container">
        <span class="meu_texto" id="lbl_f_pagamento" style="font-size: 16px; color: #000000;  ">Forma de Pagamento:</span>
        <select class="form-select" id="forma_pagamento">
          <option value="0">Selecione</option>
          <?php foreach ((array('Dinheiro', 'Carteira Crédito', 'Pix')) as $key => $elemento) { ?>
            <option value="<?php echo (array('Dinheiro', 'Carteira Crédito', 'Pix'))[$key]; ?>"><?php echo $elemento; ?></option>
          <?php } ?>
        </select>
        <div style="width:10px;height:10px;"></div>
        <div id="tela_cupon" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
          <div id="tela_cc" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 80%;">
            <input type="text" class="form-control" id="box_cupon" placeholder="Cupon de Desconto">
          </div>
          <div style="flex: 1"></div>
          <div id="id_da_tela" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 15%;">
            <button type="button" onclick="validar_cupon()" id="valida_cupon" class="btn btn-primary"><i class="bi bi-check-circle"></i></button>
            <button type="button" onclick="v_l()" id="v_l" class="btn btn-success"><i class="bi bi-check-circle"></i></button>
          </div>
        </div>
      </div>
      <div style="width:10px;height:10px;"></div>
      <div id="tela_card_iniciar_chamado" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <div class="meu_card" id="card_iniciar_chamado" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);">
          <span class="meu_texto" id="txt_card_chamado" style="font-size: 16px; color: #ffffff; font-weight: bold; "></span>
        </div>
      </div>
      <div style="width:10px;height:5px;"></div>
    </div>



    <div id="loading" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
      <img src="assets/loading.gif" height="100px" width="100px" id="img_loading">
    </div>



    <div class="modal fade" id="modal_pix" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pagamento via Pix</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container" id="id_do_container">
              <span class="meu_texto" id="txt_ info_pix" style="font-size: 16px; color: #000000;  ">Escaneie ou copie o codigo pix abaixo:</span>
              <div id="tela_img_pix" class="text-center" style="background-color: #ffffff; height: auto; width: 100%;">
                <img src="" style="height: 200px; width: 200px;" id="img_pix"><input type="text" class="form-control" id="pix_copia_cola" placeholder="">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="cancelar_pix()" id="cancelar_pix" class="btn btn-warning">Cancelar</button>
            <button type="button" onclick="copiar_pix()" id="copiar_pix" class="btn btn-primary">Selecionar Pix</button>
          </div>
        </div>
      </div>
    </div>



    <div id="tela_btn_avancar" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
      <div class="meu_card" id="btn_avancar" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);">
        <span class="meu_texto" id="lbl_avancar" style="font-size: 16px; color: #ffffff;  ">Avançar</span>
      </div>
    </div>
    <script>
      if ("serviceWorker" in navigator) {
        window.addEventListener("load", function() {
          navigator.serviceWorker.register("sw.js").then(function(registration) {
            console.log("ServiceWorker registration successful with scope: ", registration.scope);
          }, function(err) {
            console.log("ServiceWorker registration failed: ", err);
          });
        });
      }

      window.addEventListener("beforeinstallprompt", function(e) {
        console.log("beforeinstallprompt Event fired");
      });
    </script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js" integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- firebase-app -->
    <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js"></script>
    <!-- firebase-database -->
    <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-database.js"></script>
    <!-- firebase-auth -->
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-auth.js"></script>
    <!-- Lottie files -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- codigo javascript -->
    <script src="home.js?v=<?php echo time(); ?>">
    </script>
  </div>
</body>

</html>