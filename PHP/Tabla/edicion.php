<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../../Index.php");
    exit();
}

// Obtener datos de la URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$descripcion = isset($_GET['descripcion']) ? $_GET['descripcion'] : '';
$precio = isset($_GET['precio']) ? $_GET['precio'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Editar Producto</h1>
    <form id="formEdicion" method="post">
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
        <div class="form-group">
            <label for="disponibilidad">Disponibilidad</label>
            <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" value="<?php echo htmlspecialchars($disponibilidad); ?>">
        </div>
        <div class="mt-3">
            <a href="../welcome.php" class="btn btn-primary">Cancelar</a>
            <button type="submit" class="btn btn-warning" id="btnGuardar">Guardar</button>
            <button type="submit" name="guardar_continuar" class="btn btn-success" id="btnGuardarContinuar">Guardar y continuar</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#formEdicion').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: 'guardar_edicion.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        Swal.fire({
                            title: 'Guardado',
                            text: 'El producto ha sido guardado exitosamente.',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            window.location.href = '../welcome.php';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        });

        $('#btnGuardarContinuar').click(function(event) {
            event.preventDefault();
            $.ajax({
                url: 'guardar_edicion.php',
                type: 'POST',
                data: $('#formEdicion').serialize(),
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        Swal.fire({
                            title: 'Guardado',
                            text: 'El producto ha sido guardado exitosamente.',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        });
    });
</script>
</body>
</html>

