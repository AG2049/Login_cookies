<?php
session_start();
include("PHP/SQL/connection.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    function Contraseña($new_password){
        if(strlen($new_password)<8 || strlen($new_password)>12){
            return false;
        }
        if(!preg_match('/\d/', $new_password)){
            return false;
        }
        if(!preg_match('/[!@#$%^&*]/', $new_password)){
            return false;
        }
        return true;
    }

    function Usuario($new_username){
        if(strlen($new_username)<8 || strlen($new_username)>12){
            return false;
        }
        if(!preg_match('/\d/', $new_username)){
            return false;
        }
        if(!preg_match('/[!@#$%^&*]/', $new_username)){
            return false;
        }
        return true;
    }

    if(Contraseña($new_password)==false){
        //Alerta de que la contraseña no cumple parametros
        echo json_encode(array('success' => 0));
        exit();
    }
    if(Usuario($new_username)==false){//requisitos usuario
        //Alerta de que la usuario no cumple parametros
        echo json_encode(array('success' => 1));
        exit();
    }
    if($new_password!=$confirm_password){
        //No conincide contraseñas
        echo json_encode(array('success' => 2));
        exit();
    }
    $PasswordCifrada = base64_encode($new_password);
    $UserCifrado = base64_encode($new_username);
    try {
        $InsertQuery = mysqli_query($conection, "INSERT INTO `usuarios` (`ID_usuario`,`user_name`,`password`) VALUES (NULL, '$UserCifrado', '$PasswordCifrada')");
        echo json_encode(array('success' => 3));
    } catch (Exception $e) {
        echo json_encode(array('success' => 4));
        exit();
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;600&display=swap" rel="stylesheet">
    <link href="CSS/index.css" rel="stylesheet">
</head>
<body class="bg-custom-dark text-white">
    <section>
        <div class="row g-0">
            <div class="col-lg-5 d-flex justify-content-center align-items-center min-vh-100 mx-auto">
                <div class="container">
                    <div class="login-box px-lg-5 pt-lg-3 pb-lg-4 p-4">
                        <h2 class="text-center mb-4">Crear una cuenta</h2>
                        <form action="register.php" method="POST" id="NewUser">
                            <div class="form-group"> 
                                <label for="new_username" class="form-label font-weight-bold">Usuario:</label>
                                <input type="text" class="form-control bg-withe-x border-0" style="background-color: #333333; color: #ffffff;" placeholder="Ingresa tu Usuario" id="new_username" name="new_username" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="form-label font-weight-bold">Contraseña:</label>
                                <input type="password" class="form-control bg-withe-x border-0" style="background-color: #333333; color: #ffffff;" placeholder="Ingresa tu Contraseña" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="form-label font-weight-bold">Confirmar contraseña:</label>
                                <input type="password" class="form-control bg-withe-x border-0" style="background-color: #333333; color: #ffffff;" placeholder="Confirma tu Contraseña" id="new_password2" name="confirm_password" required>
                            </div>
                            <div>
                                <label for="">Tanto usuario como contraseña necesitan:</label>
                                <ul>
                                    <li>Tener mas de 8 y menos de 12 caracteres</li>
                                    <li>Tener un numero</li>
                                    <li>Tener minimo uno de estos caracteres ! @ # $ % ^ & *</li>
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-primary text-center w-100 align-self-center">Crear cuenta</button>
                            <a href="index.php" class="d-block text-center mt-3 text-decoration-none">Volver al inicio</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="JS/Register.js"></script>
</body>
</html>