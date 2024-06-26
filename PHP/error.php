<?php
session_start();

if (!isset($_SESSION['login_failed'])) {
    header("Location: ../index.php");
    exit();
}

unset($_SESSION['login_failed']);
session_regenerate_id(true);
session_unset();
session_destroy();
setcookie('username', '', time() - 3600, "/");
setcookie('password', '', time() - 3600, "/");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
        <div class="alert alert-danger text-center" role="alert">
            <h2 class="alert-heading">Error</h2>
            <p>Verifique que los datos son correctos.</p>
            <hr>
            <a href="../Index.php" class="btn btn-danger">Intentar de nuevo</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
</body>
</html>