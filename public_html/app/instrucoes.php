<!DOCTYPE html>
        <html lang="pt-br">
        <head><meta charset="utf-8">
            
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="theme-color" content="#000000">
            <title>Instruções MovFacil</title> <!-- TÍTULO OK -->
            <!-- bootstrap css -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
            </head>
        <body>
        <div id="loading-page-bb" style="opacity: 0; height: 100%;">
            <?php
?>


  <div class="container" id="id_do_container">
    <!-- O ESPAÇO NO TOPO FOI PREENCHIDO COM UM CABEÇALHO DE CONTEXTO -->
    <div id="id_da_tela" class="classe_da_tela" style="background-color: #ffffff; height: 100%; width: 100%;">
      
        <!-- NOVO CABEÇALHO DE TÍTULO: Adicionado para preencher o espaço superior de forma lógica -->
        <header class="text-center py-3 mb-3 bg-light border-bottom">
            <h1 class="h5 text-dark m-0">MovFacil Driver - Guia de Instalação</h1>
        </header>

        <!-- BOTÃO VOLTAR NO INÍCIO (agora sem margem superior - mt-0 implícito) -->
        <div class="mb-3">
            <button type="button" onclick="history.back()" class="btn btn-secondary btn-sm">
              <i class="bi bi-arrow-left"></i> Voltar
            </button>
        </div>
      
      <!-- NOVO TEXTO DE CHAMADA E BOTÃO DE DOWNLOAD NO INÍCIO -->
      <span class="meu_texto d-block mb-3" id="txt_chamada_download" style="font-size: 18px; font-weight: bold; color: #000000;">Baixe aqui o App Driver:</span>
      
      <button type="button" onclick="iniciar_download()" id="btn_download" class="btn btn-primary mb-5"><i class="bi bi-android2"></i> Download Aplicativo Motorista</button>
      

      <!-- RESTANTE DAS INSTRUÇÕES -->
      <span class="meu_texto" id="instrucoes" style="font-size: 16px; color: #000000;  "><p>Aqui est&aacute; o exemplo revisado de como instalar e cadastrar no aplicativo MovFacil Driver:</p> <p>1. <strong>Veja o v&iacute;deo 1 de como instalar</strong>   Assista ao v&iacute;deo explicativo sobre o processo de instala&ccedil;&atilde;o para se familiarizar.</p> <p>2. <strong>Baixe o aplicativo abaixo</strong>   Baixe o aplicativo motoristas (arquivo APK) abaixo nesta p&aacute;gina abaixo (veja as instru&ccedil;&otilde;es )</p> <p>3. <strong>Verifique nos downloads o arquivo APK</strong>   Acesse a pasta de downloads no seu dispositivo Android para localizar o arquivo (**motorista_movfacil.apk**) .</p> <p>4. <strong>Clique para abrir arquivoso APK aplicativo</strong>   Toque no (arquivo **motorista_movfacil.apk** ) para iniciar o processo de instala&ccedil;&atilde;o.</p> <p>5. <strong>Permita a instala&ccedil;&atilde;o do aplicativo</strong>   Na janela que aparecer&aacute;, escolha &quot;Instalar sem an&aacute;lise&quot; ou simplesmente permita a instala&ccedil;&atilde;o conforme as instru&ccedil;&otilde;es do sistema.</p> <p>6. <strong>Ap&oacute;s a instala&ccedil;&atilde;o, veja o v&iacute;deo 2 sobre como se cadastrar</strong>   Ap&oacute;s concluir a instala&ccedil;&atilde;o, assista ao segundo v&iacute;deo tutorial para aprender a se cadastrar.</p> <p>7. <strong>Abra o seu aplicativo instalado</strong>   Ap&oacute;s ver o v&iacute;deo, abra o aplicativo MovFacil Driver que foi instalado.</p> <p>8. <strong>Clique em &quot;Cadastrar&quot;</strong>   No aplicativo, selecione a op&ccedil;&atilde;o de &quot;Cadastrar&quot; para iniciar seu registro.</p> <p>9. <strong>Preencha e envie seus documentos de motorista</strong>   Siga as instru&ccedil;&otilde;es do app para preencher os dados solicitados e anexar os docSumentos necess&aacute;rios.</p> <p>10. <strong>Aguarde a aprova&ccedil;&atilde;o ap&oacute;s envio dos seus dados e documentos</strong>   Ap&oacute;s enviar todas as informa&ccedil;&otilde;es, aguarde a aprova&ccedil;&atilde;o do seu cadastro para come&ccedil;ar a utilizar o aplicativo.</p> <p>11. Seja bme vindo Motorista </p></span>
      <div style="width:10px;height:10px;"></div>
      <span class="meu_texto" id="txt_instalacao" style="font-size: 16px; color: #000000;  ">Veja como instalar aplicativo motorista</span>
      <!-- YouTube_Player -->
      <iframe id="video_yt" src="https://www.youtube.com/embed/U8nrTTDXEPE" height="200px" width="100%"allow="clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" controls  allowfullscreen></iframe>
      <div style="width:10px;height:10px;"></div>
      <span class="meu_texto" id="txt_video_cadastrar" style="font-size: 16px; color: #000000;  ">Veja como Cadastrar</span>
      <!-- YouTube_Player -->
      <iframe id="video_yt" src="https://www.youtube.com/embed/8HuXahkLOo8" height="200px" width="100%"allow="clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" controls  allowfullscreen></iframe>
      <div style="width:10px;height:10px;"></div>
    </div>
    <!-- NOVO: BOTÃO VOLTAR NO FINAL -->
    <div class="d-grid gap-2">
        <button type="button" onclick="history.back()" class="btn btn-outline-secondary mt-3 mb-4">
            <i class="bi bi-arrow-left"></i> Voltar para a Página Anterior
        </button>
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <!-- jquery -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js" xintegrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <!-- firebase-app -->
            <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js"></script>
            <!-- firebase-database -->
            <script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-database.js"></script>
            <!-- firebase-auth -->
            <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-auth.js"></script>
            <!-- codigo javascript -->
            <script src= "instrucoes.js?v=1.3"> </script>
        </div>
        </body>
        </html>