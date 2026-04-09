<style>
    :root {
        --nav-bg: #ffffff;
        --nav-text: #2c3e50;
        --nav-accent: #27ae60;
        /* Verde dinero */
        --nav-height: 70px;
        /* AJUSTA AQUÍ EL TAMAÑO VERTICAL */
    }

    .custom-navbar {
        background-color: var(--nav-bg);
        border: none;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        min-height: var(--nav-height);
        display: flex;
        align-items: center;
    }

    .navbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0 20px;
    }

    /* Logo - Ajuste de tamaño */
    .nav-logo img {
        height: 80px;
        /* AJUSTA AQUÍ EL TAMAÑO DEL LOGO */
        width: 80px;
        border-radius: 80%;
        object-fit: cover;
        border: 2px solid var(--nav-accent);
        transition: transform 0.3s;
    }

    .nav-logo img:hover {
        transform: scale(1.1);
    }

    /* Enlaces del menú */
    .nav-links {
        list-style: none;
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .nav-links li a {
        color: var(--nav-text);
        text-decoration: none;
        padding: 10px 15px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .nav-links li a:hover {
        color: var(--nav-accent);
    }

    .user-info-pill {
        background: #f1f7ff;
        border-radius: 20px;
        padding: 5px 15px !important;
        margin: 0 10px;
        border: 1px solid #ddecff;
    }

    .btn-logout {
        color: #e74c3c !important;
        /* Rojo para salir */
        border: 1px solid #f5b7b1;
        border-radius: 8px;
        margin-left: 10px;
    }

    .btn-logout:hover {
        background: #e74c3c;
        color: white !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .user-name-text {
            display: none;
        }

        /* Oculta nombre en celular */
    }
</style>

<nav class="custom-navbar">
    <div class="navbar-container">

        <div style="display: flex; align-items: center;">
            <a href="index.php" class="nav-logo">
                <img src="../imagenes/dolar2.jpg" alt="Logo Empresa">
            </a>
            <ul class="nav-links" style="margin-left: 15px;">
                <li>
                    <a href="index.php">
                        <i class="fa fa-home" style="margin-right: 5px;"></i> Inicio
                    </a>
                </li>
            </ul>
        </div>

        <ul class="nav-links">
            <li class="user-name-text">
                <a href="#" class="user-info-pill">
                    <i class="fa fa-shield-halved" style="color: var(--nav-accent); margin-right: 8px;"></i>
                    <?php
                    $roles = [
                        1 => "Administrador",
                        2 => "Cobrador",
                        3 => "Cliente"
                    ];
                    ?>
                    <span style="color: #7f8c8d; font-size: 12px; margin-right: 5px;">
                        ID: <?php echo $roles[$rol_user] ?? "Desconocido"; ?>
                    </span>
                    <strong><?php echo $user_nombre; ?></strong>
                </a>
            </li>
            <li>
                <a href="../modelo/salir.php" class="btn-logout">
                    <i class="fa fa-sign-out-alt"></i> <span class="user-name-text">Salir</span>
                </a>
            </li>
        </ul>

    </div>
</nav>