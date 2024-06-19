<?php
session_start();

// Si no se establece el indicador de inicio de sesión fallido, redirigir a la página de inicio
if (!isset($_SESSION['login_failed'])) {
    header("Location: ../Index.php");
    exit();
} else {
    // Eliminar la variable de sesión de inicio de sesión fallido
    unset($_SESSION['login_failed']);
}

// Destruir completamente la sesión
session_destroy();

// Borrar las cookies
setcookie('username', '', time() - 3600, "/");
setcookie('password', '', time() - 3600, "/");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <h2>Error: Verifique que los datos son correctos.</h2>
    <a href="../Index.php">Intentar de nuevo</a>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
    <script>
        Swal.fire({
            title: "Error",
            text: "Usuario o contraseña incorrectos",
            icon: "error"
        });
    </script>
</body>
</html>
