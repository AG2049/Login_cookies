<?php
session_start();
ini_set('display_errors', E_ALL);
include("../SQL/products.php");

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php"); // Redirigir a la página de inicio de sesión si no hay sesión activa
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
<html lang="es" onload="carga();">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <!-- Incluir CSS de Bootstrap y DataTables -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <!-- Incluir Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../CSS/welcomeNormal.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <a href="../logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Catálogo</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="#" id="verCarrito" class="btn btn-primary"><i class="fas fa-shopping-cart"></i></a>
            </div>
            <table id="miTabla" class="table table-striped table-bordered" style="width:100%">
                <thead class="thead-dark">
                    <tr>         
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Disponibilidad</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $i<count($id_producto); $i++){
                            if($numero_disponibles[$i]>0){
                                echo '<tr class="table-primary" id="fila-'. $id_producto[$i] .'">';
                                echo "<td>{$nombre_producto[$i]}</td>";
                                echo "<td>{$descripcion_producto[$i]}</td>";
                                echo "<td>{$precio_producto[$i]}</td>";
                                echo '<td><img src="data:image/jpeg;base64,' . $imagen_producto[$i] . '" alt="Imagen" width="300px"></td>';
                                echo '<td><p id="disponibles">'.$numero_disponibles[$i].'</p></td>';
                                echo '<td><input type="number" id="cantidad" class="form-control cantidad" name="cantidad" min="1" max="'.$numero_disponibles[$i].'" data-id="'.$id_producto[$i].'" value=0></td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
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
<script src="../../JS/WelcomeNormal.js"></script>
<script>
    $('#miTabla').DataTable();

    // Mostrar alerta de inicio de sesión exitoso solo una vez
    if (<?php echo json_encode($_SESSION['login_success']); ?>) {
        mostrarAlertaLoginExitoso();
        <?php $_SESSION['login_success'] = false; ?>
    }
</script>
</html>