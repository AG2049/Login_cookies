<?php
session_start();

// Redirigir a welcome.php si la sesión ya está iniciada
if (isset($_SESSION['username'])) {
    header("Location: welcome.php?login=success");
    exit();
}

// Iniciar sesión automáticamente si existen las cookies
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    header("Location: welcome.php?login=success");
    exit();
}

$saved_username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

// Credenciales válidas (debes reemplazarlas con tu validación real)
$valid_username = 'admin';
$valid_password = 'password123';

// Validar las credenciales del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;

        // Si el usuario marca "Recuérdame"
        if (isset($_POST['remember'])) {
            setcookie('username', $username, time() + (86400 * 30), "/");
            setcookie('password', $password, time() + (86400 * 30), "/");
        } else {
            setcookie('username', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

        header("Location: welcome.php?login=success");
        exit();
    } else {
        $_SESSION['login_failed'] = true;
        header("Location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/xampp/php/valdepeña/style.css">
    <style>
    :root {
        --dark: #16191C;
        --dark-x: #1E2126; 
        --light: #ffffff;
    }

    body {
        font-family: 'Spartan', sans-serif;
        font-weight: 300;
        background-color:#1E2126 !important; /* Color de fondo personalizado */
    }

    .text-light { color: var(--light) !important; }
    .bg-dark { background-color: var(--dark) !important; }
    .bg-dark-x { background-color: var(--dark-x); }

    .bg-custom-dark {
        background-color: #1E2126 !important; /* Color de fondo personalizado */
    }

    .login-box .btn-primary {
        background: linear-gradient(to right, #7e57c2, #ab47bc);
        border: none;
    }

    .login-box .btn-primary:hover {
        background: linear-gradient(to right, #ab47bc, #7e57c2);
    }

    .login-box a {
        color: #ab47bc;
    }

    .login-box a:hover {
        color: #7e57c2;
    }

    .form-control {
        min-height: 3.125rem;
        line-height: initial;
    }
    .form-control:focus {
        background-color: var(--dark-x);
        outline: none;
    }

    .img-1 {
        background-image: url('img-1.jpg');
        background-size: cover;
        background-position: center;
    }

    .img-2 {
        background-image: url('img-2.jpg');
        background-size: cover;
        background-position: center;
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
                            <img src="/xampp/php/valdepeña/imagenes/img-1.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <!-- <h5 class="font-weight-bold">La más potente del mercado</h5> --> 
                            </div>
                        </div>
                        <div class="carousel-item img-2 min-vh-100">
                            <img src="C:\Users\Antonio\OneDrive\Documents\PruebasPWeb" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <!-- <h5 class="font-weight-bold">Descubre la nueva generación</h5> --> 
                                <!-- <a class="text-muted text-decoration-none">Visita nuestra tienda</a> --> 
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
                                <input type="text" class="form-control bg-withe-x border-0" placeholder="Ingresa tu Usuario" id="username" name="username" value="<?php echo htmlspecialchars($saved_username); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label font-weight-bold">Contraseña:</label>
                                <input type="password" class="form-control bg-withe-x border-0" placeholder="Ingresa tu Contraseña" id="password" name="password" value="<?php echo htmlspecialchars($saved_password); ?>" required>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="check" <?php echo $saved_username ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="remember">Recuérdame</label>
                            </div>
                            <button type="submit" class="btn btn-primary text-center w-100 align-self-center">Iniciar sesión ahora</button>
                            <a href="#" class="d-block text-center mt-3 text-decoration-none text-info">¿Olvidaste tu contraseña?</a>
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
