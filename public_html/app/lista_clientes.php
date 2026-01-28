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
                        <span id="nome_motorista">MovFacil Entregas</span>
                    </span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <span id="status_motorista" class="text-success">Lista de Clientes</span>
                </div>
            </div>
        </div>
    </div>
    <!-- div para a lista de entregas -->

    <div class="container mt-4">
        <div id="lista_clientes" class="row">
        </div>
    </div>

    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarClienteLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarCliente">
                        <div class="mb-3">
                            <label for="nome_cliente" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone_cliente" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o telefone" required>
                        </div>
                        <div class="mb-3">
                            <label for="endereco_entrega" class="form-label">Endereço de Entrega</label>
                            <textarea class="form-control" id="endereco_entrega" name="endereco_entrega" placeholder="rua/n°, qd e lt, bairro, cidade" rows="3" required></textarea>
                        </div>
                        <input type="hidden" id="id_cliente" value="">
                        <button type="submit" id="salvar" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <audio id="audio_alerta" style="display: none;" src="assets/toque_status.mp3" preload="auto"></audio>
    <?php
    include_once 'menu_entregas.php';
    ?>

    <script>
        url_principal = localStorage.getItem('url_principal') || '';
        var telefone_cliente = localStorage.getItem('telefone_cliente') || '';
        var senha_cliente = localStorage.getItem('senha_cliente') || '';
        var lista_clientes = [];
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


        function carregarClientes() {
            console.log('Carregando clientes...');
            $.ajax({
                url: url_principal + 'get_clientes.php',
                type: 'POST',
                data: {
                    telefone: telefone_cliente,
                    senha: senha_cliente
                },
                dataType: 'json',
                success: function(response) {
                    // Limpa a lista atual
                    $('#lista_clientes').empty();

                    if (response.status === 'success' && response.clientes.length > 0) {
                        lista_clientes = response.clientes;
                        // Adiciona cada cliente à lista
                        response.clientes.forEach(function(cliente) {
                            $('#lista_clientes').append(`
                                <div class="col-12 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title text-primary">
                                                        <i class="bi bi-person-circle"></i> ${cliente.nome}
                                                    </h5>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-telephone text-success"></i> 
                                                        <strong>Telefone:</strong> ${cliente.telefone || 'Não informado'}
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-geo-alt text-danger"></i> 
                                                        <strong>Endereço:</strong> ${cliente.endereco_entrega || 'Não informado'}
                                                    </p>
                                                </div>
                                                <div class="btn-group-vertical ms-3" role="group">
                                                    <button type="button" class="btn btn-outline-primary btn-sm mb-1" 
                                                            onclick="editarCliente(${cliente.id})" title="Editar Cliente">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                                            onclick="excluirCliente(${cliente.id})" title="Excluir Cliente">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        // Exibe mensagem quando não há clientes
                        $('#lista_clientes').append(`
                            <div class="col-12">
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="bi bi-info-circle"></i>
                                    ${response.message || 'Nenhum cliente encontrado.'}
                                </div>
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao carregar clientes:', error);
                    $('#lista_clientes').html(`
                        <div class="col-12">
                            <div class="alert alert-danger text-center" role="alert">
                                <i class="bi bi-exclamation-triangle"></i>
                                Erro ao carregar a lista de clientes. Tente novamente.
                            </div>
                        </div>
                    `);
                }
            });
        }


        function editarCliente(id) {
            // Implementar função de edição
            console.log('Editar cliente:', id);
            //procura o cliente na lista
            var cliente = lista_clientes.find(c => c.id == id);
            if (cliente) {
                // Preenche o formulário com os dados do cliente
                $('#nome').val(cliente.nome);
                $('#telefone').val(cliente.telefone);
                $('#endereco_entrega').val(cliente.endereco_entrega);
                $('#id_cliente').val(cliente.id);
                // Exibe o modal
                var modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                modal.show();
            }
        }

        //quando o formulário de edição for enviado
        $('#formEditarCliente').on('submit', function(event) {
            event.preventDefault();
            var id = $('#id_cliente').val();
            var nome = $('#nome').val();
            var telefone = $('#telefone').val();
            var endereco_entrega = $('#endereco_entrega').val();
            // Envia os dados para o servidor
            $.ajax({
                url: url_principal + "editar_sub_cliente.php",
                method: 'POST',
                data: {
                    id: id,
                    nome: nome,
                    telefone: telefone,
                    endereco_entrega: endereco_entrega,
                    telefone_cliente: telefone_cliente,
                    senha_cliente: senha_cliente
                },
                success: function(response) {
                    response = typeof response === 'string' ? JSON.parse(response) : response;
                    if (response.status === 'sucesso') {
                        // Atualiza a lista de clientes
                        carregarClientes();
                        // Fecha o modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCliente'));
                        modal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: 'Cliente editado com sucesso!'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Não foi possível editar o cliente. Tente novamente.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao editar cliente:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro ao editar cliente. Tente novamente.'
                    });
                }
            });
        });

        function excluirCliente(id) {
            // Implementar função de exclusão
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url_principal + "excluir_sub_cliente.php",
                        method: 'POST',
                        data: {
                            id: id,
                            telefone_cliente: telefone_cliente,
                            senha_cliente: senha_cliente
                        },
                        success: function(response) {
                            console.log('Resposta do servidor:', response);
                            response = typeof response === 'string' ? JSON.parse(response) : response;
                            if (response.status === 'sucesso') {
                                // Atualiza a lista de clientes
                                carregarClientes();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso',
                                    text: 'Cliente excluído com sucesso!'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: 'Não foi possível excluir o cliente. Tente novamente.'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro ao excluir cliente:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Erro ao excluir cliente. Tente novamente.'
                            });
                        }
                    });
                }
            });
        }
        // Carrega os clientes ao inicializar a página
        $(document).ready(function() {
            carregarClientes();
        });
    </script>
</body>