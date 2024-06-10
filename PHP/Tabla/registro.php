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
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-primary">
                <td>1</td>
                <td>Producto 1</td>
                <td>Descripción 1</td>
                <td>$100</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>2</td>
                <td>Producto 2</td>
                <td>Descripción 2</td>
                <td>$200</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>3</td>
                <td>Producto 3</td>
                <td>Descripción 3</td>
                <td>$300</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <!-- Agrega más filas según sea necesario -->
            <tr class="table-primary">
                <td>4</td>
                <td>Producto 4</td>
                <td>Descripción 4</td>
                <td>$400</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>5</td>
                <td>Producto 5</td>
                <td>Descripción 5</td>
                <td>$500</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>6</td>
                <td>Producto 6</td>
                <td>Descripción 6</td>
                <td>$600</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>7</td>
                <td>Producto 7</td>
                <td>Descripción 7</td>
                <td>$700</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>8</td>
                <td>Producto 8</td>
                <td>Descripción 8</td>
                <td>$800</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>9</td>
                <td>Producto 9</td>
                <td>Descripción 9</td>
                <td>$900</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
            <tr class="table-primary">
                <td>10</td>
                <td>Producto 10</td>
                <td>Descripción 10</td>
                <td>$1000</td>
                <td><input type="checkbox" class="seleccionar"></td>
            </tr>
        </tbody>
    </table>
    <div class="mt-3">
        <a href="../../Index.php" class="btn btn-primary">Regresar</a>
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