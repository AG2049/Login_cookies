<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Exitosa</title>
    <!-- Incluir CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-success" role="alert">
        ¡Compra realizada con éxito!
    </div>
    <a href="welcomeNormal.php" class="btn btn-primary">Volver al catálogo</a>
</div>
<script>
    window.onload = function() {
        // Limpiar el localStorage
        localStorage.clear();
    };
</script>
</body>
</html>