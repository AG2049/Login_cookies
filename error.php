<?php
session_start();

if (!isset($_SESSION['login_failed'])) {
    header("Location: index.php");
    exit();
} else {
    unset($_SESSION['login_failed']); // Eliminar la variable para que la página de error no sea accesible directamente
}
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
    <a href="index.php">Intentar de nuevo</a>

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
