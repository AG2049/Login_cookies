<?php
session_start();
ini_set('display_errors',E_ALL);
include("SQL/products.php");

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../Index.php");
    exit();
}
if($_SESSION['user_type']==false){
    header("Location: user/welcomeNormal.php");
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
    <link rel="stylesheet" href="../CSS/Welcome.css"
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb3">
        <h1>Bienvenido, <?php echo htmlspecialchars(base64_decode(base64_encode($_SESSION['username']))); ?>!</h1>
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
                        for($i=0; $i<count($id_producto); $i++){
                            echo '<tr class="table-primary" id="fila-'. $id_producto[$i] .'">';
                            echo "<td>{$id_producto[$i]}</td>";
                            echo "<td>{$nombre_producto[$i]}</td>";
                            echo "<td>{$descripcion_producto[$i]}</td>";
                            echo "<td>{$precio_producto[$i]}</td>";
                            echo '<td class="ContenedorCentro"><img src="data:image/jpeg;base64,' . $imagen_producto[$i] . '" alt="Imagen" class="ProuctoImagen"></td>';
                            echo "<td>{$numero_disponibles[$i]}</td>";
                            echo '<td class="ContenedorCentro">
                                    <button class="btn btn-info btn-sm btn-ver mb-2" onclick="verprod(this)">Ver</button>
                                    <button class="btn btn-warning btn-sm btn-editar mb-2" onclick="editarprod(this)">Editar</button>
                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar mb-2" onclick="eliminarprod(this)">Eliminar</button>
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
<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir JS de DataTables y Bootstrap -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
<script src="../JS/Botones_welcome.js"></script>
<script>
    $(document).ready(function() {
        inicializaDataTables();

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
</html>