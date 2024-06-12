<?php
session_start();
ini_set('display_errors', E_ALL);
include("SQL/products.php");

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Variable de sesión para mostrar la alerta de inicio de sesión exitoso una sola vez
if (!isset($_SESSION['login_success'])) {
    $_SESSION['login_success'] = true;
} else {
    $_SESSION['login_success'] = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <!-- Incluir CSS de Bootstrap y DataTables -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir JS de DataTables y Bootstrap -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
    <script>
        function eliminarProducto(id) {
            $.ajax({
                url: 'PHP/eliminar_producto.php', // Archivo que procesará la solicitud
                type: 'POST',
                data: { id_producto: id },
                success: function(response) {
                    if (response == 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'Tu registro ha sido eliminado.',
                            'success'
                        );
                        $('#producto-' + id).remove();
                    } else {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el producto.',
                            'error'
                        );
                    }
                }
            });
        }

        $(document).ready(function() {
            $('#miTabla').DataTable();

            // Manejar búsqueda en tiempo real
            $('#buscarProducto').on('keyup', function() {
                var valorBusqueda = $(this).val();
                $.ajax({
                    url: 'PHP/buscar_producto.php',
                    type: 'POST',
                    data: { query: valorBusqueda },
                    success: function(response) {
                        $('tbody').html(response);
                    }
                });
            });

            // Manejar clic en botón "Ver"
            $('.btn-ver').click(function() {
                var id = $(this).closest('tr').find('td:eq(0)').text();
                var nombre = $(this).closest('tr').find('td:eq(1)').text();
                var descripcion = $(this).closest('tr').find('td:eq(2)').text();
                var precio = $(this).closest('tr').find('td:eq(3)').text();
                var imagen = $(this).closest('tr').find('img').attr('src');
                var disponibilidad = $(this).closest('tr').find('td:eq(5)').text();
                // Redireccionar a registro.php con parámetros
                window.location.href = 'registro.php?id=' + id + '&nombre=' + encodeURIComponent(nombre) + '&descripcion=' + encodeURIComponent(descripcion) + '&precio=' + encodeURIComponent(precio) + '&imagen=' + encodeURIComponent(imagen) + '&disponibilidad=' + encodeURIComponent(disponibilidad);
            });

            // Manejar clic en botón "Editar"
            $('.btn-editar').click(function() {
                var id = $(this).closest('tr').find('td:eq(0)').text();
                var nombre = $(this).closest('tr').find('td:eq(1)').text();
                var descripcion = $(this).closest('tr').find('td:eq(2)').text();
                var precio = $(this).closest('tr').find('td:eq(3)').text();
                var imagen = $(this).closest('tr').find('img').attr('src');
                var disponibilidad = $(this).closest('tr').find('td:eq(5)').text();

                // Redireccionar a edicion.php con parámetros
                var form = $('<form action="Tabla/edicion.php" method="POST">' +
                '<input type="hidden" name="id" value="' + id + '" />' +
                '<input type="hidden" name="nombre" value="' + nombre + '" />' +
                '<input type="hidden" name="descripcion" value="' + descripcion + '" />' +
                '<input type="hidden" name="precio" value="' + precio + '" />' +
                '<input type="hidden" name="imagen" value="' + imagen + '" />' +
                '<input type="hidden" name="disponibilidad" value="' + disponibilidad + '" />' +
                '</form>');
                $('body').append(form);
                form.submit();
            });

            // Manejar clic en botón "Eliminar"
            $('.btn-eliminar').click(function() {
                var id = $(this).closest('tr').find('td:eq(0)').text(); // Obtener el ID del producto de la primera columna
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarProducto(id);
                    }
                });
            });

            // Mostrar alerta de inicio de sesión exitoso solo una vez
            if (<?php echo json_encode($_SESSION['login_success']); ?>) {
                mostrarAlertaLoginExitoso();
                <?php $_SESSION['login_success'] = false; ?>
            }

            // Manejar clic en botón "Agregar"
            $('.btn-agregar').click(function() {
                // Redirigir a edicion.php con parámetros vacíos
                window.location.href = 'Tabla/edicion.php?id=&nombre=&descripcion=&precio=&imagen=&disponibilidad=';
            });

            function mostrarAlertaLoginExitoso() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Te has logeado exitosamente',
                    showConfirmButton: false,
                    timer: 1200
                });
            }
        });
    </script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb3">
        <h1>Bienvenido, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>!</h1>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Catálogo</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-success btn-agregar"> &#x1f7a6;</button>
            </div>
            <table id="miTabla" class="table table-striped table-bordered" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (is_array($id_producto) && is_array($nombre_producto) && is_array($descripcion_producto) && is_array($precio_producto) && is_array($imagen_producto) && is_array($numero_disponibles)) {
                            for($i=0; $i<count($id_producto); $i++){
                                echo '<tr class="table-primary" id="producto-' . $id_producto[$i] . '">';
                                echo "<td>{$id_producto[$i]}</td>";
                                echo "<td>{$nombre_producto[$i]}</td>";
                                echo "<td>{$descripcion_producto[$i]}</td>";
                                echo "<td>{$precio_producto[$i]}</td>";
                                echo '<td><img src="data:image/jpeg;base64,' . $imagen_producto[$i] . '" alt="Imagen"></td>';
                                echo "<td>{$numero_disponibles[$i]}</td>";
                                echo '<td>
                                        <button class="btn btn-info btn-sm btn-ver">Ver</button>
                                        <button class="btn btn-warning btn-sm btn-editar">Editar</button>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="' . $id_producto[$i] . '">Eliminar</button>
                                    </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7">No hay productos disponibles</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>