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
    })(window, document, 'script', 'dataLayer', 'GTM-5XXLVTK4');
  </script>
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5XXLVTK4"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div id="loading-page-bb" style="opacity: 0; height: 100%;">
    <?php
    ?>


    <div style="width:10px;height:30px;"></div>
    <div id="tela_logo" class="tela-logins" style="background-color: #ffffff; height: 100%; width: 100%;">
      <img src="assets/passageiro.png" height="220px" width="220px" id="logo">
    </div>
    <div id="tela_text_box" class="tela-logins" style="background-color: #ffffff; height: auto; width: 100%;">
      <p style="color: #000000; font-size: 16px; font-weight: bold; ">LOGIN</p>
    </div>
    <div style="width:10px;height:5px;"></div>
    <div class="container" id="login">
      <input type="text" class="form-control" id="telefone_box" placeholder="Telefone">
      <div style="width:10px;height:10px;"></div>
      <input type="text" class="form-control" id="senha_box" placeholder="Senha">
      <div id="tela_recuperar" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="recuperar_lbl" style="font-size: 16px; color: #000000;  "><?php echo "<span style='color:#ff0000;'>" . 'Esqueceu a Senha?' . "</span>"; ?></span>
      </div>
      <div style="width:10px;height:20px;"></div>
      <button type="button" onclick="login()" id="logar_btn" class="btn btn-warning">Entrar</button>
      <div style="width:10px;height:20px;"></div>
      <div id="tela_cadastrar" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
        <span class="meu_texto" id="cadastrar_lbl" style="font-size: 20px; color: #000000;  "><?php echo ('Não tem Cadastro? ' . "<span style='color:#009900;'>" . 'CADASTRAR ' . "</span>"); ?></span>
      </div>
    </div>



    <div class="modal fade" id="modal_nova_senha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nova Senha</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="meu_texto" id="txt_nova_senha" style="font-size: 16px; color: #000000;  ">Insira uma nova senha:</span>
            <div style="width:10px;height:10px;"></div>
            <input type="text" class="form-control" id="senha_1" placeholder="Senha">
            <div style="width:10px;height:10px;"></div>
            <input type="text" class="form-control" id="senha_2" placeholder="Repita a Senha">
          </div>
          <div class="modal-footer">
            <button type="button" onclick="salvar_senha()" id="btn_salvar_senha" class="btn btn-primary">Salvar</button>
          </div>
        </div>
      </div>
    </div>






    <div class="modal fade" id="modal_tipo_verificacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Verifica Telefone</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="meu_texto" id="txt_t_verificar" style="font-size: 16px; color: #000000;  ">Selecione a forma de verificação:</span>
            <div style="width:10px;height:10px;"></div>
            <?php
            $i = 0;
            foreach ((array('SMS')) as $elemento) {
              $i = $i + 1; ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="selecao_tipo_verificar" id="selecao_tipo_verificar_<?php echo $i; ?>" value="<?php echo $elemento; ?>">
                <label class="form-check-label" for="selecao_tipo_verificar_<?php echo $i; ?>"><?php echo $elemento; ?></label>
              </div>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <button type="button" onclick="enviar_otp()" id="btn_enviar_codigo" class="btn btn-primary">Enviar Código</button>
          </div>
        </div>
      </div>
    </div>



    <div class="modal fade" id="modal_otp_verificacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Digite o código recebido:</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="meu_texto" id="txt_verificar_otp" style="font-size: 16px; color: #000000;  ">Digite o código recebido:</span>
            <div style="width:10px;height:10px;"></div>
            <input type="text" class="form-control" id="box_otp" placeholder="Código Recebido">
          </div>
          <div class="modal-footer">
            <button type="button" onclick="verificar_otp()" id="btn_verificar_otp" class="btn btn-primary">Verificar</button>
          </div>
        </div>
      </div>
    </div>



    <div id="loading" class="classe_da_tela" style="background-color: #ffffff; height: auto; width: 100%;">
      <img src="assets/loading.gif" height="100px" width="100px" id="img_loading">
    </div>



    <div class="modal fade" id="modal_recuperar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Recuperar a Senha</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="meu_texto" id="txt_recuperar" style="font-size: 16px; color: #000000;  ">Preencha com seu telefone:</span>
            <div style="width:10px;height:5px;"></div>
            <input type="text" class="form-control" id="telefone_recuperar" placeholder="Telefone">
          </div>
          <div class="modal-footer">
            <button type="button" onclick="recuperar()" id="recuperar_btn" class="btn btn-primary">Recuperar Senha</button>
          </div>
        </div>
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
    <!-- codigo javascript -->
    <script src="login.js?v=<?php echo time(); ?>"></script>
  </div>
</body>

</html>