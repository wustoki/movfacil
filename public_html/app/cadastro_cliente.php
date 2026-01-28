<?php
include_once '../_/bd/config.php';
$background_color = "#000000ff";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head><meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="<?php echo $background_color; ?>">
    <title><?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/imask"></script>
</head>
<style>
    .cabecalho {
        background-color: #000000ff;
        color: white;
        padding: 10px;
        text-align: center;

    }
</style>

<body>

    <div class="cabecalho">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <span>
                        <i class="bi bi-truck"></i>
                        <span id="nome_motorista">MovFacil Entregas</span>
                    </span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <span id="status_motorista" class="text-success">Cadastro de Clientes</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4 mb-4">
        <form id="form-cadastro-cliente" autocomplete="off">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Digite o telefone" required>
            </div>
            <div class="mb-3">
                <label for="endereco_entrega" class="form-label">Endereço de Entrega</label>
                <input type="text" class="form-control" id="endereco_entrega" name="endereco_entrega" placeholder="rua/n°, qd e lt, bairro, cidade" required>
            </div>
            <div class="mb-3">
                <label for="link_localizacao" class="form-label">Link da localização</label>
                <input type="text" class="form-control" id="link_localizacao" name="link_localizacao" placeholder="Opcional">
                <span id="status_link" class="form-text">Insira o link da localização do cliente compartilhada do whatsapp ou google maps.</span>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="bi bi-person-plus"></i>
                Cadastrar Cliente
            </button>
        </form>
    </div>
    <audio id="audio_alerta" style="display: none;" src="assets/alert.mp3" preload="auto"></audio>
    <?php
    include_once 'menu_entregas.php';
    ?>

</body>


<script>
    url_principal = localStorage.getItem('url_principal') || '';
    var box_endereco_entrega = document.getElementById('endereco_entrega');
    var box_telefone = document.getElementById('telefone');
    var box_nome = document.getElementById('nome');
    var telefone_cliente = localStorage.getItem('telefone_cliente') || '';
    var senha_cliente = localStorage.getItem('senha_cliente') || '';
    //se não tiver telefone ou senha, redireciona para login
    if (!telefone_cliente || !senha_cliente) {
        Swal.fire({
            icon: 'error',
            title: 'Acesso Negado',
            text: 'Você precisa fazer login para acessar esta página.',
        }).then(() => {
            window.location.href = 'login.php';
        });
    }
    //quando link_localizacao for preenchido, extrai latitude e longitude
    document.getElementById('link_localizacao').addEventListener('input', function() {
        const input = this.value;
        const regex = /[?&]q=([-.\d]+),([-.\d]+)/;
        const match = input.match(regex);
        if (match) {
            window.lat = match[1];
            window.lng = match[2];
            document.getElementById('status_link').textContent = `Latitude: ${lat}, Longitude: ${lng}`;
            document.getElementById('status_link').classList.remove('text-danger');
            document.getElementById('status_link').classList.add('text-success');
        } else {
            document.getElementById('status_link').textContent = 'Insira o link da localização do cliente compartilhada do whatsapp ou google maps.';
            document.getElementById('status_link').classList.remove('text-success');
            document.getElementById('status_link').classList.add('text-danger');
        }
        //se lat e lng estiver ok e o campo do endereço estiver vazio, preenche o campo com a localização com base no openstreetmap
        if (window.lat && window.lng && box_endereco_entrega.value === '') {
            // Faz uma requisição reversa para obter o endereço pelo OpenStreetMap Nominatim
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${window.lat}&lon=${window.lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        box_endereco_entrega.value = data.display_name;
                    } else {
                        box_endereco_entrega.value = `https://www.openstreetmap.org/?mlat=${window.lat}&mlon=${window.lng}#map=16/${window.lat}/${window.lng}`;
                    }
                })
                .catch(() => {
                    box_endereco_entrega.value = `https://www.openstreetmap.org/?mlat=${window.lat}&mlon=${window.lng}#map=16/${window.lat}/${window.lng}`;
                });
        }
    });

    //mascara para telefone
    var telefoneMask = IMask(box_telefone, {
        mask: '(00) 00000-0000'
    });

    //envia o formulário e bloqueia o botão
    document.getElementById('form-cadastro-cliente').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        formData.set('telefone', telefoneMask.value); // pega o valor formatado do telefone
        formData.set('latitude', window.lat || '');
        formData.set('longitude', window.lng || '');
        formData.set('telefone_cliente', telefone_cliente);
        formData.set('senha_cliente', senha_cliente);

        fetch(url_principal + 'cad_sub_cliente.php', {
            method: 'POST',
            body: formData // ENVIA COMO FORM DATA, NÃO JSON!
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status === 'sucesso') {
                Swal.fire({
                    icon: 'success',
                    title: 'Cadastro realizado com sucesso!',
                    text: 'O cliente foi cadastrado com sucesso.',
                });
                this.reset(); // Limpa o formulário
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao cadastrar',
                    text: data.mensagem ? data.mensagem : data.status,
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao cadastrar',
                text: 'Ocorreu um erro ao tentar cadastrar o cliente.',
            });
        });
    });






</script>