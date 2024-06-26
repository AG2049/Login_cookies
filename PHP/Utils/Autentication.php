<?php
// Obtener el nombre de usuario y la contraseña guardados de las cookies
$saved_username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['username'])) {
    // Si el usuario ya está autenticado, redirigirlo a la página de bienvenida correspondiente
    if ($_SESSION['user_type'] == 1) {
        header("Location: PHP/welcome.php");
    } else {
        echo "Pagina de usuario";
        session_destroy();
        //header("Location: PHP/error.php");
    }
    exit();
}

// Verificar si las cookies de "Recordarme" existen y si sí, intentar iniciar sesión directamente
if (!empty($saved_username) && !empty($saved_password)) {
    // Validar las credenciales del usuario utilizando las cookies
    for ($i = 0; $i < count($userName); $i++) {
        if ($saved_username === $userName[$i] && $saved_password === $passwords[$i]) {
            // Almacenar el nombre de usuario y el tipo de usuario en la sesión
            $_SESSION['username'] = $saved_username;
            $_SESSION['user_type'] = $userType[$i];
            
            // Redirigir al usuario según su tipo
            if ($userType[$i] == 1) {
                // Si el usuario es admin (1), redirigir a la página de bienvenida de administrador
                header("Location: PHP/welcome.php");
            } else {
                header("Location: PHP/user/welcomeNormal.php");
            }
            exit();
        }
    }
}
?>