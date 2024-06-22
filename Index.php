<?php
session_start();

include("PHP/SQL/users.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("PHP/Utils/Autentication.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar las credenciales del usuario
    for ($i = 0; $i < count($userName); $i++) {
        if ($username === $userName[$i] && $password === $passwords[$i]) {
            // Almacenar el nombre de usuario y el tipo de usuario en la sesión
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $userType[$i];

            // Manejar la funcionalidad "Recordarme"
            if (isset($_POST['remember'])) {
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
            } else {
                setcookie('username', '', time() - 3600, "/");
                setcookie('password', '', time() - 3600, "/");
            }

            // Redirigir al usuario según su tipo
            if ($userType[$i] == 1) {
                // Si el usuario es admin (1), redirigir a la página de bienvenida de administrador
                header("Location: PHP/welcome.php");
            } else {
                // Si el usuario no es admin (1), redirigir a la página de bienvenida de usuario normal
                header("Location: PHP/user/welcomeNormal.php");
            }
            exit();
        }
    }

    // Si las credenciales no coinciden, establecer un mensaje de error
    $_SESSION['login_failed'] = true;
    header("Location: PHP/error.php");
    exit();

    if($fail=1){
        echo "Swal.fire({";
        echo 'title: "Error",';
        echo 'text: "Usuario o contraseña incorrectos",';
        echo 'icon: "error"';
        echo "});";
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
    <link href="CSS/index.css" rel="stylesheet">
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
