<style>
    :root {
        --primary-color: #4361ee;
        /* Azul moderno */
        --secondary-color: #3a0ca3;
        /* Azul mais escuro */
        --text-color: #2b2d42;
        /* Cinza escuro quase preto */
        --text-light: #8d99ae;
        /* Cinza claro */
        --bg-color: rgba(255, 255, 255, 0.98);
        /* Branco com leve transparência */
        --shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    body {
        margin: 0;
        padding-bottom: 80px;
        /* Espaço para o menu */
        background: #f8f9fa;
    }

    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: var(--bg-color);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: var(--shadow);
        display: flex;
        justify-content: space-around;
        padding: 12px 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        z-index: 1000;
    }

    .nav-item {
        text-align: center;
        flex: 1;
        position: relative;
    }

    .nav-item a {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: var(--text-light);
        font-size: 12px;
        font-weight: 500;
        padding: 8px 0;
        transition: var(--transition);
        position: relative;
    }

    .nav-item a i {
        font-size: 22px;
        margin-bottom: 5px;
        transition: var(--transition);
    }

    .nav-item a.active {
        color: var(--primary-color);
    }

    .nav-item a.active i {
        transform: translateY(-5px);
    }

    /* Indicador do item ativo */
    .nav-item a.active::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 5px;
        height: 5px;
        background: var(--primary-color);
        border-radius: 50%;
        opacity: 0;
        transition: var(--transition);
    }

    .nav-item a:hover {
        color: var(--primary-color);
    }

    .nav-item a:hover i {
        transform: scale(1.1);
    }

    .nav-item a.active:hover::after {
        opacity: 1;
        bottom: -8px;
    }

    /* Efeito de clique */
    .nav-item a:active {
        transform: scale(0.95);
    }

    /* Efeito de onda ao clicar */
    .nav-item a::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(67, 97, 238, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.5s ease-out, opacity 0.5s ease-out;
        opacity: 0;
        pointer-events: none;
    }

    .nav-item a:active::before {
        transform: translate(-50%, -50%) scale(10);
        opacity: 0.3;
        transition: transform 0.2s ease-out, opacity 0.2s ease-out;
    }
</style>

<nav class="bottom-nav" id="menu">
    <div class="nav-item">
        <a href="entregas.php" id="entregas" class="active">
            <i class="bi bi-truck"></i>
            <span>Entregas</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="nova_entrega.php" id="nova_entrega">
            <i class="bi bi-plus-circle"></i>
            <span>Nova Entrega</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="cadastro_cliente.php" id="cadastro_cliente">
            <i class="bi bi-person-plus"></i>
            <span>Cadastrar</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="lista_clientes.php" id="lista_clientes">
            <i class="bi bi-people"></i>
            <span>Lista Clientes</span>
        </a>
    </div>
</nav>

<script>
    //script to handle active state of menu items
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.nav-item a');
        const currentPath = window.location.pathname.split('/').pop();

        menuItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    });
</script>