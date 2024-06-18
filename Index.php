<?php
session_start();

include("PHP/SQL/users.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener el nombre de usuario y la contraseña guardados de las cookies
$saved_username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username'])) {
    header("Location: PHP/welcome.php?login=success");
    exit();
}

// Verificar si las cookies de "Recordarme" existen y si sí, intentar iniciar sesión directamente
if (!empty($saved_username) && !empty($saved_password)) {
    for ($i = 0; $i < count($userName); $i++) {
        if ($saved_username === $userName[$i] && $saved_password === $passwords[$i]) {
            $_SESSION['username'] = $saved_username;
            $_SESSION['user_type'] = $userType[$i];
            header("Location: PHP/welcome.php");
            exit();
        }
    }
}

// Validar las credenciales del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $isAuthenticated = false;

    for ($i = 0; $i < count($userName); $i++) {
        if ($username === $userName[$i] && $password === $passwords[$i]) {
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $userType[$i];
            $isAuthenticated = true;

            if (isset($_POST['remember'])) {
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
            } else {
                setcookie('username', '', time() - 3600, "/");
                setcookie('password', '', time() - 3600, "/");
            }

            header("Location: PHP/welcome.php");
            exit();
        }
    }

    if (!$isAuthenticated) {
        $_SESSION['login_failed'] = true;
        header("Location: PHP/error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ROG</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link href="CSS/index.css" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #0f0f0f;
            --dark-x: #1c1c1c; 
            --light-text: #e0e0e0;
            --primary-color: #bc002d;
            --accent-color: #a3a3a3;
        }

        body {
            font-family: 'Orbitron', sans-serif;
            background-color: var(--dark-bg) !important;
            color: var(--light-text);
        }

        .text-light { color: var(--light-text) !important; }
        .bg-dark { background-color: var(--dark-bg) !important; }
        .bg-dark-x { background-color: var(--dark-x); }

        .bg-custom-dark {
            background-color: var(--dark-bg) !important;
        }

        .login-box .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }

        .login-box .btn-primary:hover {
            background-color: darken(var(--primary-color), 10%);
        }

        .login-box a {
            color: var(--accent-color);
        }

        .login-box a:hover {
            color: lighten(var(--accent-color), 10%);
        }

        .form-control {
            min-height: 3.125rem;
            line-height: initial;
            background-color: var(--dark-x);
            color: var(--light-text);
            border: 1px solid var(--accent-color);
        }
        .form-control:focus {
            background-color: var(--dark-x);
            color: var(--light-text);
            outline: none;
            border: 1px solid var(--primary-color);
        }

        .img-1 {
            background-image: url('IMG/img-1.jpg');
            background-size: cover;
            background-position: center;
        }

        .img-2 {
            background-image: url('IMG/img-2.jpg');
            background-size: cover;
            background-position: center;
        }

        .carousel-caption h5 {
            font-weight: 700;
            color: var(--light-text);
            background-color: rgba(0, 0, 0, 0.5);
            padding: 0.5rem;
        }
    </style>
</head>
<body class="bg-custom-dark text-white">
    <section>
        <div class="row g-0">
            <div class="col-lg-7 d-none d-lg-block">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item img-1 min-vh-100 active">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="font-weight-bold">Bienvenido a ROG</h5>
                            </div>
                        </div>
                        <div class="carousel-item img-2 min-vh-100">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="font-weight-bold">La mejor experiencia de juego</h5>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-flex justify-content-center align-items-center min-vh-100">
                <div class="container">
                    <div class="login-box px-lg-5 pt-lg-3 pb-lg-4 p-4">
                        <h2 class="text-center mb-4">Login</h2>
                        <form action="index.php" method="POST">
                            <div class="form-group">
                                <label for="username" class="form-label font-weight-bold">Usuario:</label>
                                <input type="text" class="form-control" placeholder="Ingresa tu Usuario" id="username" name="username" value="<?php echo htmlspecialchars($saved_username); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label font-weight-bold">Contraseña:</label>
                                <input type="password" class="form-control" placeholder="Ingresa tu Contraseña" id="password" name="password" value="<?php echo htmlspecialchars($saved_password); ?>" required>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="check" <?php echo $saved_username ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="remember">Recuérdame</label>
                            </div>
                            <button type="submit" class="btn btn-primary text-center w-100 align-self-center">Iniciar sesión ahora</button>
                            <a href="#" class="d-block text-center mt-3 text-decoration-none">¿Olvidaste tu contraseña?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
