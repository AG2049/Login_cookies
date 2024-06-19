<?php
session_start();
ini_set('display_errors',E_ALL);
include("../Utils/UserBlock.php");

// Obtener datos de la URL
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];
$disponibilidad = $_POST['disponibilidad'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Incluir CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Ver Producto</h1>
    <form id="formEdicion" action="guardar_edicion.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea type="text" class="form-control" id="descripcion" name="descripcion" value="" disabled><?php echo htmlspecialchars($descripcion); ?></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($precio); ?>" disabled>
        </div>
        <div class="form-group">
            <label for="precio">Imagen</label><p/>
            <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen" class="img-thumbnail" id="imagenActual">
        </div>
        <div class="form-group">
            <label for="precio">Disponibilidad</label>
            <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" value="<?php echo htmlspecialchars($disponibilidad); ?>" disabled>
        </div>
        <div class="mt-3">
            <a href="../welcome.php" class="btn btn-primary">Regresar</a>
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