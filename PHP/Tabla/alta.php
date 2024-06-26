<?php
session_start();
ini_set('display_errors',E_ALL);

if($_SESSION['user_type']==false){
    header("Location: ../user/welcomeNormal.php");
}
// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Producto</title>
    <!-- Incluir CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Agregar Producto</h1>
    <form id="formEdicion" action="guardar_edicion.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="" name="id">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre"  />
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea type="text" class="form-control" id="descripcion" name="descripcion" ></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" />
        </div>
        <div class="form-group">
            <label for="precio">Imagen</label><p/>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
        <div class="form-group">
            <label for="precio">Disponibilidad</label>
            <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" />
        </div>
        <div class="mt-3">
            
            <a href="../welcome.php" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-warning" id="btnGuardar">Guardar</button>
            <button type="submit" name="guardar_continuar" class="btn btn-success" id="btnGuardarContinuar" value="1">Guardar y continuar</button>
        </div>
    </form>
</div>
<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="../../JS/Registro.js"></script>
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