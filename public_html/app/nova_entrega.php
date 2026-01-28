<?php
include_once '../_/bd/config.php';
$background_color = "#000000ff";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="<?php echo $background_color; ?>">
    <title><?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
                        <span id="nome_motorista">Wustoki Entregas</span>
                    </span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <span id="status_motorista" class="text-success">Nova Entrega</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4 mb-4">
        <form id="form-nova-entrega" autocomplete="off">
            <div class="mb-3">
                <label for="origem" class="form-label">Origem</label>
                <input type="text" class="form-control" id="origem" name="origem" required>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" value="1" id="salvar_origem" name="salvar_origem">
                    <label class="form-check-label" for="salvar_origem">
                        Salvar origem para próximas entregas
                    </label>
                </div>
                <!-- autocomplete para lista de clientes -->
                <div class="mb-3 position-relative">
                    <label for="cliente_autocomplete" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente_autocomplete" name="cliente_nome" autocomplete="off" required placeholder="Digite para buscar o cliente">
                    <input type="hidden" id="cliente" name="cliente">
                    <div id="autocomplete-list" class="list-group position-absolute w-100" style="z-index: 1000; display: none;"></div>
                </div>
                <!-- select com as categorias -->
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
                    <select class="form-select" id="forma_pagamento">
                        <option value="0">Selecione</option>
                        <option value="Dinheiro">Dinheiro</option>
                        <option value="Carteira Crédito">Carteira Crédito</option>
                    </select>
                </div>
                <!-- dois botões um para estimar as taxas e outro para enviar -->
                <div class="row g-2 align-items-center">
                    <div class="col-6 d-grid">
                        <button type="button" class="btn btn-primary" onclick="calcularEstimativas()">
                            <i class="bi bi-calculator"></i> Calcular
                        </button>
                    </div>
                    <div class="col-6 d-grid">
                        <button type="submit" class="btn btn-success" id="btn-enviar-entrega" disabled>
                            <i class="bi bi-send"></i> Enviar
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" id="card-estimativas" style="display: none;">
                    <div class="card-header">
                        Estimativas:
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Valor Total: R$ <span id="total">0,00</span> </li>
                        <li class="list-group-item">Tempo estimado: <span id="tempo">0:00</span> </li>
                        <li class="list-group-item">Km do trajeto <span id="km">0</span> </li>
                    </ul>
                </div>
            </div>
            <?php
            include_once 'menu_entregas.php';
            ?>

</body>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwV6_FYJ83dNCNr3ADVljHUYmnM9OW9UA&libraries=places&callback=initAutocomplete" async defer></script>

<script>
    function initAutocomplete() {
        const origemInput = document.getElementById('origem');
        if (origemInput) {
            const check_salvar_origem = document.getElementById('salvar_origem');
            // Usa o raio da cidade (exemplo: 20km)
            const radius = dados_cidade && dados_cidade.raio ? Number(dados_cidade.raio) : 20000;
            const center = (latitude_cidade && longitude_cidade) ? {
                lat: latitude_cidade,
                lng: longitude_cidade
            } : null;

            const options = center ? {
                bounds: new google.maps.Circle({
                    center: center,
                    radius: radius
                }).getBounds(),
                strictBounds: true
            } : {};

            const autocompleteOrigem = new google.maps.places.Autocomplete(origemInput, options);

            autocompleteOrigem.addListener('place_changed', function() {
                const place = autocompleteOrigem.getPlace();
                if (place.geometry) {
                    lat_ini = place.geometry.location.lat();
                    lng_ini = place.geometry.location.lng();
                    endereco_ini = place.formatted_address || '';
                    origemInput.value = endereco_ini;
                    if (check_salvar_origem.checked) {
                        localStorage.setItem('origem', endereco_ini);
                        localStorage.setItem('lat_ini', lat_ini);
                        localStorage.setItem('lng_ini', lng_ini);
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Endereço inválido. Por favor, selecione um endereço válido.'
                    });
                }
            });
        }
    }

    url_principal = localStorage.getItem('url_principal') || '';
    url = "https://wustoki.top";
    var telefone_cliente = localStorage.getItem('telefone_cliente') || '';
    var senha_cliente = localStorage.getItem('senha_cliente') || '';
    var sub_cliente_id = 0;
    var dados_cidade = [];
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
    var lat_ini = localStorage.getItem('lat_ini') || 0;
    var lng_ini = localStorage.getItem('lng_ini') || 0;
    if (lat_ini) lat_ini = Number(lat_ini);
    if (lng_ini) lng_ini = Number(lng_ini);
    var lat_fim = 0;
    var lng_fim = 0;
    var endereco_ini = localStorage.getItem('origem') || '';
    if (endereco_ini) {
        //preenche o campo origem com o valor salvo
        document.getElementById('origem').value = endereco_ini;
        var check_salvar_origem = document.getElementById('salvar_origem');
        if (check_salvar_origem) {
            check_salvar_origem.checked = true;
        }
    }
    var endereco_fim = "";
    var km = 0;
    var tempo = 0;
    var taxa = 0;
    var latitude_cidade = 0;
    var longitude_cidade = 0;
    var telefone_sub_cliente = '';

    let lista_clientes = [];
    //carrega lista de clientes
    fetch(url_principal + 'lista_sub_clientes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                telefone_cliente: telefone_cliente,
                senha_cliente: senha_cliente
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.status === 'ok' && Array.isArray(data.sub_clientes) && data.sub_clientes.length > 0) {
                lista_clientes = data.sub_clientes;
            }
        })
        .catch(error => {
            console.error('Erro ao carregar lista de clientes:', error);
        });

    // Autocomplete logic
    const input = document.getElementById('cliente_autocomplete');
    const hiddenInput = document.getElementById('cliente');
    const autocompleteList = document.getElementById('autocomplete-list');


    input.addEventListener('input', function() {
        const value = this.value.trim().toLowerCase();
        autocompleteList.innerHTML = '';
        hiddenInput.value = '';
        if (!value || lista_clientes.length === 0) {
            autocompleteList.style.display = 'none';
            return;
        }
        const matches = lista_clientes.filter(cliente =>
            cliente.nome.toLowerCase().includes(value) ||
            (cliente.telefone && cliente.telefone.toLowerCase().includes(value))
        );
        if (matches.length === 0) {
            autocompleteList.style.display = 'none';
            return;
        }
        matches.forEach(cliente => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = cliente.nome + (cliente.telefone ? ` - ${cliente.telefone}` : '');
            item.onclick = function() {
                input.value = cliente.nome;
                hiddenInput.value = cliente.id;
                sub_cliente_id = cliente.id;
                lat_fim = cliente.latitude || 0;
                lng_fim = cliente.longitude || 0;
                lat_fim = Number(lat_fim);
                lng_fim = Number(lng_fim);
                endereco_fim = cliente.endereco_entrega || '';
                telefone_sub_cliente = cliente.telefone || '';
                autocompleteList.innerHTML = '';
                autocompleteList.style.display = 'none';

            };
            autocompleteList.appendChild(item);
        });
        autocompleteList.style.display = 'block';
    });

    function calcularEstimativas() {
        // Obtenha os valores dos campos
        const enderecoIni = document.getElementById('origem').value.trim();
        const enderecoFim = endereco_fim ? endereco_fim.trim() : '';
        const categoriaSelect = document.getElementById('categoria');
        const categoriaId = categoriaSelect && categoriaSelect.value ? categoriaSelect.value : 0;

        if (enderecoIni === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Preencha o endereço de origem',
            });
            return;
        }
        if (enderecoFim === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Selecione um cliente',
            });
            return;
        }
        if (!categoriaId || categoriaId == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Selecione a categoria',
            });
            return;
        }
        // Chame a função para buscar a taxa (exemplo)
        getTaxa();
    }

    function getTaxa() {
        // Usa os valores já definidos nas variáveis globais
        fetch(url + "/_/funcoes/get_taxa.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    cidade_id: dados_cidade && dados_cidade.id ? dados_cidade.id : 0,
                    endereco_ini: endereco_ini || '',
                    endereco_fim: endereco_fim || '',
                    categoria_id: document.getElementById('categoria').value,
                    lat_ini: lat_ini,
                    lng_ini: lng_ini,
                    lat_fim: lat_fim,
                    lng_fim: lng_fim
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Dados recebidos:', data);
                document.getElementById('total').textContent = data.taxa || '0,00';
                document.getElementById('tempo').textContent = data.minutos || '0:00';
                document.getElementById('km').textContent = data.km || '0';
                document.getElementById('card-estimativas').style.border = '1px solid green';
                km = data.km;
                tempo = data.minutos;
                taxa = data.taxa;
                // Atualiza o card de estimativas
                document.getElementById('card-estimativas').style.display = 'block';
                //habilita o botão de enviar entrega
                document.getElementById('btn-enviar-entrega').disabled = false;
            })
            .catch(error => {
                console.error('Erro ao buscar taxa:', error);
            });
    }


    // Envia a nova entrega
    function enviarEntrega() {
        // Validação dos campos
        if (!endereco_ini || !endereco_fim) {
            alert("Preencha os endereços");
            return;
        }
        const categoriaSelect = document.getElementById('categoria');
        const categoria_id = categoriaSelect && categoriaSelect.value ? categoriaSelect.value : 0;
        if (!categoria_id || categoria_id == 0) {
            alert("Selecione a categoria");
            return;
        }
        const cliente_id = document.getElementById('cliente').value;
        const cliente_nome = document.getElementById('cliente_autocomplete').value;
        const forma_pagamento = document.getElementById('forma_pagamento').value;
        if (!cliente_id) {
            alert("Selecione o cliente");
            return;
        }

        fetch(url + "/_/funcoes/insere_corrida.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    cidade_id: dados_cidade && dados_cidade.id ? dados_cidade.id : 0,
                    endereco_ini: endereco_ini,
                    endereco_fim: endereco_fim,
                    categoria_id: categoria_id,
                    lat_ini: lat_ini,
                    lng_ini: lng_ini,
                    lat_fim: lat_fim,
                    lng_fim: lng_fim,
                    nome: cliente_nome,
                    km: km,
                    tempo: tempo,
                    taxa: taxa,
                    telefone: telefone_cliente,
                    senha: senha_cliente,
                    telefone_sub_cliente: telefone_sub_cliente,
                    forma_pagamento: forma_pagamento
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Entrega enviada com sucesso',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "entregas.php";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao enviar entrega',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao enviar entrega',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
    }

    // Evento de envio do formulário
    document.getElementById('form-nova-entrega').addEventListener('submit', function(e) {
        e.preventDefault();
        enviarEntrega();
    });

    //busca as categorias
    fetch(url_principal + 'lista_categorias.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                telefone_cliente: telefone_cliente,
                senha_cliente: senha_cliente
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.status === 'ok' && Array.isArray(data.categorias)) {
                // Preencher o select com as categorias
                const categoriaSelect = document.getElementById('categoria');
                categoriaSelect.innerHTML = '';
                data.categorias.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id;
                    option.textContent = categoria.nome;
                    categoriaSelect.appendChild(option);
                });
                dados_cidade = data.cidade;
                latitude_cidade = Number(dados_cidade.latitude);
                longitude_cidade = Number(dados_cidade.longitude);
            }
            // Autocomplete initialization moved to initAutocomplete callback above.
        });
</script>