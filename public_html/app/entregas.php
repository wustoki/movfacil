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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .cabecalho {
        background-color: #000000ff;
        color: white;
        padding: 10px;
        text-align: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1050;
    }
    body {
        padding-top: 80px;
    }
</style>

<body>
 
    <div class="cabecalho">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <span>
                        <i class="bi bi-truck"></i>
                        <span id="nome_motorista">Wustoki Entregas e Delivery</span>
                    </span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <span id="status_motorista" class="text-success">Multiplas Entregas</span>
                </div>
            </div>
        </div>
    </div>
    <!-- div para a lista de entregas -->

    <div class="container mt-4">
        <div id="lista_entregas" class="row">
        </div>
    </div>
    <audio id="audio_alerta" style="display: none;" src="assets/toque_status.mp3" preload="auto"></audio>
    <?php
    include_once 'menu_entregas.php';
    ?>

</body>
<script>
    url_principal = localStorage.getItem('url_principal') || '';
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
    //busca as entregas em andamento
    function loadEntregas() {
        // Faz a requisição AJAX para buscar as entregas
        $.ajax({
            url: url_principal + 'get_entregas.php',
            method: 'POST',
            data: {
                telefone: telefone_cliente,
                senha: senha_cliente
            },
            success: function(response) {
                // Se a resposta for string, tenta converter para objeto
                let data = typeof response === 'string' ? JSON.parse(response) : response;
                if (data.status !== 'success' || !Array.isArray(data.entregas)) {
                    $('#lista_entregas').html('<div class="alert alert-warning">Nenhuma entrega encontrada.</div>');
                    return;
                }
                $('#lista_entregas').html('');
                if (data.entregas.length === 0) {
                    $('#lista_entregas').html('<div class="alert alert-info">Nenhuma entrega disponível.</div>');
                    return;
                }
                console.log(data.entregas);
                data.entregas.forEach(function(entrega) {
                    let pagoBadge = entrega.pago === "1"
                        ? '<span class="badge bg-success ms-2"><i class="bi bi-cash-coin"></i> Pago</span>'
                        : '<span class="badge bg-warning text-dark ms-2"><i class="bi bi-cash"></i> Não pago</span>';
                    let statusColors = {
                        "0": "bg-danger",
                        "1": "bg-warning text-dark",
                        "2": "bg-info text-dark",
                        "3": "bg-primary",
                        "4": "bg-success",
                        "5": "bg-danger",
                        "6": "bg-warning text-dark",
                        "7": "bg-warning text-dark",
                        "8": "bg-warning text-dark",
                        "9": "bg-warning text-dark"
                    };
                    let statusColor = statusColors[entrega.status] || "bg-secondary";
                    let statusBadge = `<span class="badge ${statusColor}"><i class="bi bi-clock"></i> ${entrega.status_texto}</span>`;
                    let card = `
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-truck"></i> Entrega #${entrega.id}</span>
                                    ${statusBadge}
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title mb-2"><i class="bi bi-person"></i> ${entrega.nome_cliente}</h5>
                                    <p class="mb-2">
                                        <i class="bi bi-geo-alt-fill text-primary"></i>
                                        <strong>Retirada:</strong><br>
                                        <span class="text-muted">${entrega.endereco_ini_txt}</span>
                                    </p>
                                    <p class="mb-2">
                                        <i class="bi bi-flag-fill text-success"></i>
                                        <strong>Destino:</strong><br>
                                        <span class="text-muted">${entrega.endereco_fim_txt}</span>
                                    </p>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <i class="bi bi-signpost"></i> <strong>${parseFloat(entrega.km).toFixed(2)} km</strong>
                                        </div>
                                        <div class="col-6">
                                            <i class="bi bi-clock-history"></i> <strong>${entrega.tempo} min</strong>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <i class="bi bi-currency-dollar"></i> <strong>Taxa:</strong> R$ ${entrega.taxa}
                                        <br>
                                        <i class="bi bi-credit-card"></i> <strong>Forma Pagamento:</strong> ${entrega.f_pagamento}
                                    </div>
                                    <div class="text-end">
                                        <span class="text-muted small"><i class="bi bi-calendar-event"></i> ${entrega.date}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#lista_entregas').append(card);
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Não foi possível carregar as entregas.'
                });
            }
        });
    }

    loadEntregas();
    //recarregar a lista de entregas a cada 10 segundos
    setInterval(loadEntregas, 10000);
</script>