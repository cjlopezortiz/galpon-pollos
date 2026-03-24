<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión | Login</title>
    <link rel="icon" type="image/jpeg" href="./imagenes/dolar1.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #27ae60; /* Verde éxito/dinero */
            --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        body {
            background: var(--bg-gradient);
            font-family: "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .container {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        /* Encabezado elegante */
        .header-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid white;
        }

        .header-title {
            font-weight: 800;
            font-size: 22px;
            color: var(--primary-color);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header-box img {
            max-height: 80px;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        /* Imagen Principal con efecto */
        .main-img-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .main-img {
            transition: transform 0.5s;
            width: 100%;
        }

        .main-img-container:hover .main-img {
            transform: scale(1.03);
        }

        /* Tarjeta de Login Moderna */
        .login-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-top: 5px solid var(--accent-color);
        }

        .login-card h3 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .input-group-text {
            background: #f8f9fa;
            border-right: none;
            color: var(--accent-color);
        }

        .form-control {
            border-left: none;
            height: 45px;
            border-radius: 0 10px 10px 0;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .btn-login {
            background: var(--accent-color);
            border: none;
            color: white;
            padding: 12px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 10px;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-login:hover {
            background: #219150;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
            color: white;
        }

        footer {
            margin-top: 50px;
            padding: 20px;
            font-size: 13px;
            color: #666;
        }

        .footer-line {
            width: 50px;
            height: 2px;
            background: var(--accent-color);
            margin: 10px auto;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-box">
            <div class="row align-items-center">
                <div class="col-3 col-md-2 text-center">
                    <img src="./imagenes/dolar2.jpg" class="img-fluid" alt="Logo">
                </div>
                <div class="col-6 col-md-8 text-center">
                    <h1 class="header-title m-0">
                        Sistema de Gestión Financiera <br>
                        <small style="font-size: 14px; color: var(--accent-color);">Norte de Santander</small>
                    </h1>
                </div>
                <div class="col-3 col-md-2 text-center">
                    <img src="./imagenes/dolar2.jpg" class="img-fluid d-none d-md-inline" alt="Logo">
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-7 text-center mb-4 mb-md-0">
                <div class="pr-md-4">
                    <h2 class="mb-4" style="font-weight: 800; color: var(--primary-color);">Panel de Control</h2>
                    <div class="main-img-container">
                        <img src="./imagenes/dolar1.jpg" class="main-img" alt="Bienvenida">
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="login-card">
                    <h3><i class="fa fa-lock-open mr-2"></i>Acceso</h3>

                    <form action="modelo/login.php" method="POST">
                        <div class="form-group">
                            <label>Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="usuario" class="form-control" placeholder="Nombre de usuario" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                </div>
                                <input type="password" name="contrasena" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="#" class="text-muted" style="font-size: 13px;">¿Olvidaste tu contraseña?</a>
                        </div>

                        <button type="submit" class="btn btn-login">
                            Entrar al Sistema <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <footer class="text-center">
            <div class="footer-line"></div>
            <p class="mb-1"><strong>SISTEMA DE GESTIÓN v1.0</strong> © 2026</p>
            <p class="mb-0">Desarrollado por: Carlos Javier Lopez - Cúcuta</p>
            <span class="badge badge-light text-muted">Entorno de Producción</span>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
