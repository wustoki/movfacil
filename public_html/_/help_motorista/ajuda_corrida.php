<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wustoki - Suporte ao Motorista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-3">
        <h2>Suporte Motorista:</h2>
        <p>SELECIONE ITEM E DESCREVA ABAIXO O FATO</p>

        <h4>PROBLEMA COM VIAGENS</h4>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="assedio" value="Assédio">
            <label class="form-check-label" for="assedio">
                <strong>Assédio:</strong> Comportamento de cunho sexual ou físico, ou comentários impróprios que gerem desconforto.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="comentarios-negativos" value="Comentários Negativos">
            <label class="form-check-label" for="comentarios-negativos">
                <strong>Comentários Negativos:</strong> Racismo, xingamentos, críticas pessoais à aparência ou higiene, desrespeito à profissão, ou acusações injustas.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="nao-pagou-viagem" value="Não quis pagar a viagem">
            <label class="form-check-label" for="nao-pagou-viagem">
                <strong>Não quis pagar a viagem:</strong> O passageiro não efetuou o pagamento da viagem.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="problema-seguranca" value="Problema com segurança">
            <label class="form-check-label" for="problema-seguranca">
                <strong>Problema com segurança:</strong> O passageiro me passou insegurança.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="achei-item" value="Achei um item">
            <label class="form-check-label" for="achei-item">
                <strong>Achei um item:</strong> Achei um item no veículo.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="acidente-viagem" value="Acidentes durante viagem">
            <label class="form-check-label" for="acidente-viagem">
                <strong>Acidentes durante viagem:</strong> Sofri um acidente durante o percurso em viagem.
            </label>
        </div>

        <h4>PROBLEMA COM APLICATIVO</h4>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="contestar-ganhos" value="Contestar ganhos">
            <label class="form-check-label" for="contestar-ganhos">
                <strong>Contestar ganhos:</strong> Problemas com repasse de ganhos semanal.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="nao-recebo-viagens" value="Não estou recebendo viagens">
            <label class="form-check-label" for="nao-recebo-viagens">
                <strong>Não estou recebendo viagens:</strong> Meu aplicativo não está recebendo viagens.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="atualizar-documentos" value="Como atualizar documentos">
            <label class="form-check-label" for="atualizar-documentos">
                <strong>Como atualizar documentos:</strong> Quer atualizar sua CNH, documento do veículo, foto ou dado cadastral.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="problema-mecanico" value="Problema mecânico">
            <label class="form-check-label" for="problema-mecanico">
                <strong>Problema mecânico:</strong> Tive um problema com meu veículo.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="problema-app" value="Problema com Aplicativo">
            <label class="form-check-label" for="problema-app">
                <strong>Problema com Aplicativo:</strong> Meu aplicativo não está funcionando.
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="problema-gps" value="Problema com Navegação">
            <label class="form-check-label" for="problema-gps">
                <strong>Problema com Navegação:</strong> Meu GPS não funciona.
            </label>
        </div>

        <br>
        <label for="descricao">Descreva o que aconteceu:</label>
        <textarea class="form-control" id="descricao" rows="4" placeholder="Descreva o ocorrido"></textarea>
        <br>
        <!-- input para uma imagem do ocorrido -->
        <label for="imagem">Anexe uma imagem do ocorrido:</label>
        <input type="file" class="form-control" id="imagem">
        <br>
        <!-- previa da imagem -->
        <img id="previa-imagem" style="display: none;" src="https://wustoki.top/_/assets/img/img_padrao.png" alt="Prévia da imagem" class="img-fluid">

        <br>
        <br>
        <div class="d-flex justify-content-center">
            <button id="btn_enviar" class="btn btn-primary btn-block">Enviar</button>
        </div>
        <br>
    </div>

</body>

</html>

<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js" integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    url_principal = "https://wustoki.top/_/help_motorista/";

    var imagem = document.getElementById('imagem');
    var previa_imagem = document.getElementById('previa-imagem');

    imagem.addEventListener('change', function() {
        var file = imagem.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            previa_imagem.src = reader.result;
            previa_imagem.style.display = 'block';
        }
        if (file) {
            reader.readAsDataURL(file);
        } else {
            previa_imagem.src = '';
        }
    });


    //permitir a seleção de apenas um item sem incluir o checkbox "bloquear_motorista"
    $('input[type="checkbox"]').on('change', function() {
        if (this.id !== 'bloquear_motorista') {
            $('input[type="checkbox"]').not(this).not('#bloquear_motorista').prop('checked', false);
        }
    });
    //pega parametro da url
    const urlParams = new URLSearchParams(window.location.search);
    id = urlParams.get('id');
    if(id == null){
        id = 0;
    }
    
        //envia o formulário para o servidor via ajax
        $('button').click(function() {
            let motivo = $('input[type="checkbox"]:checked').val();
            let descricao = $('#descricao').val();
            let imagem = $('#imagem')[0].files[0];
            let formData = new FormData();

            if (motivo == undefined) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Selecione um motivo!',
                });
            } else if (descricao == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Descreva o ocorrido!',
                });
            } else {
                formData.append('id', id);
                formData.append('motivo', motivo);
                formData.append('descricao', descricao);
                formData.append('origem', 'Motorista');
                if (imagem) {
                    formData.append('imagem', imagem);
                }

                //altera o botão para aguarde
                $('#btn_enviar').html('Aguarde...');

                $.ajax({
                    url: url_principal + 'insere_denuncia.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('ok');
                        Swal.fire({
                            icon: 'success',
                            title: 'Denúncia enviada!',
                            text: 'Veja mais detalhes no seu e-mail.',
                        }).then((result) => {
                            window.location.href = 'index.php';
                        });
                    }
                });
            }
        });


    //botao voltar
    $('#icone_voltar').click(function() {
        window.location.href = 'index.php';
    });
</script>