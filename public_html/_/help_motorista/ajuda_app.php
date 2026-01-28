<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <title>Wustoki</title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--material icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <!--  -->
    <div id="cabecalho_msg" class="classe_da_tela" style="height: 50px; width: 100%;">
        <div id="tela_icon_cabecalho" class="classe_da_tela" style=" height: auto; width: 25%;">
            <span class="material-icons" id="icone_voltar" style="font-size:24px; color:#ffffff;">arrow_back</span>
        </div>
        <div id="txt_cabecalho" class="classe_da_tela" style=" height: auto; width: 75%;">
            <span class="meu_texto" id="lbl_tela" style="font-size: 18px; color: #ffffff; font-weight: bold; ">Ajuda com App</span>
        </div>
    </div>
    <div class="container" style="margin-top: 60px;">
        <div id="problemas_app">
            <h4>Escolha uma opção:</h4>
            <br>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            GPS não está funcionando corretamente
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Verifique se o GPS do seu dispositivo está ativado.
                            Permita que o aplicativo tenha acesso à localização nas configurações do dispositivo
                            Reinicie o celular ou ajuste manualmente uma limpeza nos arquivos do seu dispositivo.
                            Caso tenha mais dúvidas
                            <a href="https://api.whatsapp.com/send?phone=556285259714&text=Olá, estou com problemas no aplicativo Wustoki, poderia me ajudar?"
                                target="_blank">clica aqui.</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            O motorista cancelou a corrida
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Sentimos muito por isso ter ocorrido, estamos trabalhando para você ter mais opção de motoristas disponíveis para diminuir o tempo de espera , temos vagas para novos motoristas e motoqueiros indique o aplicativo wustoki para Motorista ou venha fazer parte como parceiro motorista, motoqueiro ou biker entregador e aumente sua renda
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Não consigo encontrar um motorista disponível
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            temos vagas para novos motoristas e motoqueiros, indique o aplicativo wustoki para Motorista ou venha fazer parte como parceiro motorista, motoqueiro ou biker entregador e aumente sua renda.
                            Caso tenha mais dúvidas <a href="https://api.whatsapp.com/send?phone=556285259714&text=Olá, estou com problemas no aplicativo Wustoki, poderia me ajudar?"
                                target="_blank">clica aqui.</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Não consigo processar o pagamento
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>Pagamento pix:</strong> inicie uma viagem e selecione o pagamento em pix , copie e cole o código pix ou faça a leitura do QR code no seu banco de preferência faça o pagamento , automaticamente o seu aplicativo libera a sua viagem após confirmar o pagamento.
                            <br>
                            <strong>Pagamento da carteira:</strong>
                            adicione créditos em sua conta para fazer viagens nos cartões de crédito ou pix , clica em <strong>Carteira de crédito</strong>, no menu canto superior lado esquerdo do seu aplicativo.
                            <br>
                            Caso tenha mais dúvidas <a href="https://api.whatsapp.com/send?phone=556285259714&text=Olá, estou com problemas no aplicativo Wustoki, poderia me ajudar?"
                                target="_blank">clica aqui.</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            O aplicativo gerou um valor diferente do valor inicial
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Ao confirmar o início da viagem você concorda com o valor gerado no aplicativo, verifique o valor antes do início da viagem caso discorde, não inicie o chamado.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Meu método de pagamento foi recusado
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Verifique o saldo em sua conta bancária ou verifique com seu banco o motivo da falha de pagamento.
                        </div>
                    </div>
                </div>
            </div>


</body>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js" integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</html>

<script>
    //pega parametro da url
    const urlParams = new URLSearchParams(window.location.search);
    id = urlParams.get('id');
    mode = urlParams.get('mode');
    if (id != 0) {

    }
</script>