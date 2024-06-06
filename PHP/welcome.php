<?php
session_start();

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
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
        function inicializaDataTables(){
            $('#miTabla').DataTable();
        }

        $(document).ready(function() {
            inicializaDataTables();

            // Manejar clic en botón "Ver"
            $('.btn-ver').click(function() {
                // Redireccionar a registro.php
                window.location.href = 'registro.php';
            });

            // Manejar clic en botón "Editar"
            $('.btn-editar').click(function() {
                var id = $(this).closest('tr').find('td:eq(0)').text();
                var nombre = $(this).closest('tr').find('td:eq(1)').text();
                var descripcion = $(this).closest('tr').find('td:eq(2)').text();
                var precio = $(this).closest('tr').find('td:eq(3)').text();

                // Redireccionar a edicion.php con parámetros
                window.location.href = `edicion.php?id=${id}&nombre=${nombre}&descripcion=${descripcion}&precio=${precio}`;
            });

            // Manejar clic en botón "Eliminar"
            $('.btn-eliminar').click(function() {
                var fila = $(this).closest('tr');
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
                        fila.remove();
                        Swal.fire(
                            'Eliminado!',
                            'Tu registro ha sido eliminado.',
                            'success'
                        );
                    }
                });
            });
            // Verificar si el parámetro 'login=success' está en la URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('login') === 'success') {
                mostrarAlertaLoginExitoso();
            }

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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Catálogo</h2>
        </div>
        <div class="card-body">
            <table id="miTabla" class="table table-striped table-bordered" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Supongamos que llenas la tabla con datos desde tu base de datos -->
                    <tr class="table-primary">
                        <td>1</td>
                        <td>Producto 1</td>
                        <td>Descripción 1</td>
                        <td>$100</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm btn-editar">Editar</button>
                            <button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>2</td>
                        <td>Producto 2</td>
                        <td>Descripción 2</td>
                        <td>$200</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm btn-editar">Editar</button>
                            <button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>3</td>
                        <td>Producto 3</td>
                        <td>Descripción 3</td>
                        <td>$300</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm btn-editar">Editar</button>
                            <button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>4</td>
                        <td>Producto 4</td>
                        <td>Descripción 4</td>
                        <td>$400</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>5</td>
                        <td>Producto 5</td>
                        <td>Descripción 5</td>
                        <td>$500</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>6</td>
                        <td>Producto 6</td>
                        <td>Descripción 6</td>
                        <td>$600</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>7</td>
                        <td>Producto 7</td>
                        <td>Descripción 7</td>
                        <td>$700</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>8</td>
                        <td>Producto 8</td>
                        <td>Descripción 8</td>
                        <td>$800</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>9</td>
                        <td>Producto 9</td>
                        <td>Descripción 9</td>
                        <td>$900</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="table-primary">
                        <td>10</td>
                        <td>Producto 10</td>
                        <td>Descripción 10</td>
                        <td>$1000</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver">Ver</button>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>