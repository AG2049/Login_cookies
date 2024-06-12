<?php
// Recuperar los datos de la URL si están presentes
$id = isset($_GET['id']) ? $_GET['id'] : null;
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
$descripcion = isset($_GET['descripcion']) ? $_GET['descripcion'] : null;
$precio = isset($_GET['precio']) ? $_GET['precio'] : null;
$imagen = isset($_GET['imagen']) ? $_GET['imagen'] : null;
$disponibilidad = isset($_GET['disponibilidad']) ? $_GET['disponibilidad'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Incluir CSS de Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Tabla de Registro</h1>
        <table id="miTabla" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Disponibilidad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los datos en la tabla
                if ($id !== null && $nombre !== null && $descripcion !== null && $precio !== null && $imagen !== null && $disponibilidad !== null) {
                    echo '<tr class="table-primary">';
                    echo "<td>{$id}</td>";
                    echo "<td>{$nombre}</td>";
                    echo "<td>{$descripcion}</td>";
                    echo "<td>{$precio}</td>";
                    echo '<td><img src="' . $imagen . '" alt="Imagen"></td>';
                    echo "<td>{$disponibilidad}</td>";
                    echo '</tr>';
                }
                ?>
            </tbody>
    </table>
    <div class="mt-3">
        <a href="Index.php" class="btn btn-primary">Regresar</a>
        <button id="btnEditar" class="btn btn-warning">Editar</button>
        <button id="btnEliminar" class="btn btn-danger">Eliminar</button>
    </div>
</div>

<!-- Incluir jQuery desde CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir JavaScript de Bootstrap desde CDN -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Incluir SweetAlert2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        // Manejar clic en botón "Editar"
        $('#btnEditar').click(function() {
            editarFilasSeleccionadas();
        });

        // Manejar clic en botón "Eliminar"
        $('#btnEliminar').click(function() {
            eliminarFilasSeleccionadas();
        });
    });

    function editarFilasSeleccionadas() {
        // Recorrer todas las filas y verificar si están seleccionadas
        $('#miTabla tbody tr').each(function() {
            var checkbox = $(this).find('.seleccionar');
            if (checkbox.prop('checked')) {
                var fila = $(this);
                // Obtener los valores actuales de la fila
                var id = fila.find('td:eq(0)').text();
                var nombre = fila.find('td:eq(1)').text();
                var descripcion = fila.find('td:eq(2)').text();
                var precio = fila.find('td:eq(3)').text();

                // Mostrar un cuadro de diálogo para editar los valores usando SweetAlert2
                Swal.fire({
                    title: 'Editar Producto',
                    html:
                        `<input id="swal-input1" class="swal2-input" placeholder="Nombre" value="${nombre}">` +
                        `<input id="swal-input2" class="swal2-input" placeholder="Descripción" value="${descripcion}">` +
                        `<input id="swal-input3" class="swal2-input" placeholder="Precio" value="${precio}">`,
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            nuevoNombre: document.getElementById('swal-input1').value,
                            nuevaDescripcion: document.getElementById('swal-input2').value,
                            nuevoPrecio: document.getElementById('swal-input3').value
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var nuevoNombre = result.value.nuevoNombre;
                        var nuevaDescripcion = result.value.nuevaDescripcion;
                        var nuevoPrecio = result.value.nuevoPrecio;

                        // Actualizar los valores en la fila si se han proporcionado nuevos valores
                        if (nuevoNombre != null && nuevoNombre.trim() !== "") {
                            fila.find('td:eq(1)').text(nuevoNombre);
                        }
                        if (nuevaDescripcion != null && nuevaDescripcion.trim() !== "") {
                            fila.find('td:eq(2)').text(nuevaDescripcion);
                        }
                        if (nuevoPrecio != null && nuevoPrecio.trim() !== "") {
                            fila.find('td:eq(3)').text(nuevoPrecio);
                        }

                        // Deseleccionar la fila
                        checkbox.prop('checked', false);
                    }
                });
            }
        });
    }

    function eliminarFilasSeleccionadas() {
        // Recorrer todas las filas y verificar si están seleccionadas
        var filasSeleccionadas = [];
        $('#miTabla tbody tr').each(function() {
            var checkbox = $(this).find('.seleccionar');
            if (checkbox.prop('checked')) {
                filasSeleccionadas.push($(this));
            }
        });

        if (filasSeleccionadas.length > 0) {
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    filasSeleccionadas.forEach(function(fila) {
                        fila.remove();
                    });
                    Swal.fire(
                        'Eliminado!',
                        'Tu archivo ha sido eliminado.',
                        'success'
                    );
                }
            });
        } else {
            Swal.fire(
                'No se seleccionaron filas',
                'Por favor, selecciona al menos una fila para eliminar.',
                'info'
            );
        }
    }
</script>
</body>
</html>