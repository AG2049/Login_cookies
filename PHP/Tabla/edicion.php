<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../../Index.php");
    exit();
}

// Obtener datos de la URL
$id = $_GET['id'];
$nombre = $_GET['nombre'];
$descripcion = $_GET['descripcion'];
$precio = $_GET['precio'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición</title>
    <!-- Incluir CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Editar Producto</h1>
    <form id="formEdicion" action="guardar_edicion.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($descripcion); ?>">
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($precio); ?>">
        </div>
        <div class="mt-3">
            <a href="../welcome.php" class="btn btn-primary">Cancelar</a>
            <button type="submit" class="btn btn-warning" id="btnGuardar">Guardar</button>
            <button type="submit" name="guardar_continuar" class="btn btn-success" id="btnGuardarContinuar">Guardar y continuar</button>
        </div>
    </form>
</div>
<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        // Manejar el clic en el botón "Guardar"
        $('#btnGuardar').click(function(event) {
            event.preventDefault(); // Prevenir la sumisión del formulario inmediatamente
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres guardar los cambios?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formEdicion').submit(); // Enviar el formulario si se confirma
                }
            });
        });

        // Manejar el clic en el botón "Guardar y continuar"
        $('#btnGuardarContinuar').click(function(event) {
            event.preventDefault(); // Prevenir la sumisión del formulario inmediatamente
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres guardar los cambios y continuar editando?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar y continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'guardar_continuar',
                        value: 'true'
                    }).appendTo('#formEdicion');
                    $('#formEdicion').submit(); // Enviar el formulario si se confirma
                }
            });
        });
    });
</script>
</body>
</html>