<?php
session_start();

// Si la sesión ya está iniciada, redirigir a welcome.php
if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit();
}

// Si existen las cookies, iniciar sesión automáticamente
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    header("Location: welcome.php");
    exit();
}

$saved_username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

// Ejemplo de credenciales para validar (debes cambiar esto con la validación real)
$valid_username = 'admin';
$valid_password = 'password123';

// Validar las credenciales del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Suponiendo que la validación es exitosa
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;

        // Si el usuario marca "Recuérdame"
        if (isset($_POST['remember'])) {
            setcookie('username', $username, time() + (86400 * 30), "/"); // Expira en 30 días
            setcookie('password', $password, time() + (86400 * 30), "/");
        } else {
            // Si no, eliminar las cookies
            setcookie('username', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

        header("Location: welcome.php");
        exit();
    } else {
        echo "Credenciales incorrectas";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    
    <link rel="stylesheet" href="/xampp/php/valdepeña/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;600&display=swap" rel="stylesheet">
   
<!--<link href="styles.css" rel="stylesheet" bg-dark>-->

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

                      <!--<<h5 class="font-weight-bold">La más potente del mercado</h5>>--> 

                          
                        </div>
                      </div>
                      <div class="carousel-item img-2 min-vh-100">
                      <img src="/xampp/php/valdepeña/imagenes/img-2.jpg"class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                          <!--<<h5 class="font-weight-bold">Descubre la nueva generación</h5>>--> 
                          <!--<<a class="text-muted text-decoration-none">Visita nuestra tienda</a>>--> 
                          
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


     <div class="container ">

     
        <div class="login-box px-lg-5 pt-lg-3 pb-lg-4 p-4">
            <h2 class="text-center mb-4">Login</h2>

            <form action="index.php" method="POST">
                <div class="form-group"> 
    
                    <label for="username" class="form-label font-weight-bold ">Usuario:</label>
                    <input type="text" class="form-control bg-dark-x border-0" placeholder="Ingresa tu Usuario" id="username" name="username" value="<?php echo htmlspecialchars($saved_username); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label font-weight-bold">Contraseña:</label>
                    <input type="password" class="form-control bg-dark-x border-0" placeholder="Ingresa tu Contraseña" id="password" name="password" value="<?php echo htmlspecialchars($saved_password); ?>" required>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/ffec4ec2ed.js" crossorigin="anonymous"></script>
</body>
</html>
