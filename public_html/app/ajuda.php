<!DOCTYPE html>
        <html lang="pt-br">
        <head><meta charset="utf-8">
            
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="theme-color" content="#000000">
            <title>BootBlocks</title>
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
            </head>
        <body>
        <div id="loading-page-bb" style="opacity: 0; height: 100%;">
            <?php
?>

<?php
  if (filter_input(INPUT_GET, 'id' , FILTER_SANITIZE_STRING)) {
    $id = filter_input(INPUT_GET, 'id' , FILTER_SANITIZE_STRING);
    $url = 'https://movfacil.com.br/_/help/ajuda_corrida.php?mode=appusuario&id=0' . $id;
    ?>
      <!-- iframe_html -->
      <iframe src="<?php echo $url ; ?>" height="100%" width="100%" id="'v_web_1'" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
    <?php
  } else {
    $url = 'https://movfacil.com.br/_/help/ajuda_app.php';
    ?>
      <!-- iframe_html -->
      <iframe src="<?php echo $url ; ?>" height="100%" width="100%" id="'v_web_1'" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
    <?php
  }
?>
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
            <script src= "ajuda.js?v=<?php echo time(); ?>"></script>
        </div>
        </body>
           <h1>Teste</h1>
        </html>