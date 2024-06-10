<?php
session_start();
ini_set('display_errors',E_ALL);
include("SQL/products.php");

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../Index.php");
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
        function eliminarProducto(id){
            document.getElementById("id_producto").value = id;
            document.getElementById("deleteForm").submit();
        }

        function inicializaDataTables(){
            $('#miTabla').DataTable();
        }

        $(document).ready(function() {
            inicializaDataTables();

            // Manejar clic en botón "Ver"
            $('.btn-ver').click(function() {
                // Redireccionar a registro.php
                window.location.href = 'Tabla/registro.php';
            });

            // Manejar clic en botón "Editar"
            $('.btn-editar').click(function() {
                var id = $(this).closest('tr').find('td:eq(0)').text();
                var nombre = $(this).closest('tr').find('td:eq(1)').text();
                var descripcion = $(this).closest('tr').find('td:eq(2)').text();
                var precio = $(this).closest('tr').find('td:eq(3)').text();

                // Redireccionar a edicion.php con parámetros
                window.location.href = `Tabla/edicion.php?id=${id}&nombre=${nombre}&descripcion=${descripcion}&precio=${precio}`;
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
                    Swal.fire(
                        'Eliminado!',
                        'Tu registro ha sido eliminado.',
                        'success'
                    );
                        var id = fila.find('td:eq(0)').text(); // Obtener el ID del producto de la primera columna
                        eliminarProducto(id);
                        fila.remove();
                    }
                });
            });

            // Mostrar alerta de inicio de sesión exitoso solo una vez
            if (<?php echo json_encode($_SESSION['login_success']); ?>) {
                mostrarAlertaLoginExitoso();
                <?php $_SESSION['login_success'] = false; ?>
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
    <div class="d-flex justify-content-between align-items-center mb3">
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
                        <th>Imagen</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $i<count($id_producto); $i++){
                            echo '<tr class="table-primary">';
                            echo "<td>{$id_producto[$i]}</td>";
                            echo "<td>{$nombre_producto[$i]}</td>";
                            echo "<td>{$descripcion_producto[$i]}</td>";
                            echo "<td>{$precio_producto[$i]}</td>";
                            echo '<td><img src="data:image/jpeg;base64,' . $imagen_producto[$i] . '" alt="Imagen"></td>';
                            echo "<td>{$numero_disponibles[$i]}</td>";
                            echo '<td>
                                    <button class="btn btn-info btn-sm btn-ver">Ver</button>
                                    <button class="btn btn-warning btn-sm btn-editar">Editar</button>
                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
                                  </td>';
                        }
                    ?>
                </tbody>
            </table>
            <form id="deleteForm" action="SQL/DeleteProduct.php" method="POST">
                <input type="hidden" id="id_producto" name="id_producto">
            </form>
        </div>
    </div>
</div>
</body>
</html>