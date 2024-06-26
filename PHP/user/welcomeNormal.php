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
<html lang="es">
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
    <link rel="stylesheet" href="../../CSS/welcome.css">
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
                <a href="#" id="verCarrito" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Ver Carrito</a>
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
                                echo '<td class="ContenedorCentro"><img src="data:image/jpeg;base64,' . $imagen_producto[$i] . '" alt="Imagen" class="ProuctoImagen"></td>';
                                echo '<td><p id="disponibles-'.$id_producto[$i].'">'.$numero_disponibles[$i].'</p></td>';
                                echo '<td><input type="number" id="cantidad-'.$id_producto[$i].'" class="form-control cantidad" name="cantidad" min="0" step="1" data-id="'.$id_producto[$i].'" value="" max="'.$numero_disponibles[$i].'"></td>';
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
$(document).ready(function() {
    const sessionKey = '<?php echo session_id(); ?>';

    // Función para guardar el estado de los inputs de cantidad en localStorage
    function guardarEstadoCantidad() {
        $('.cantidad').each(function() {
            var idProducto = $(this).data('id');
            var cantidad = $(this).val();
            if (cantidad > 0) {
                localStorage.setItem(sessionKey + '_cantidad_' + idProducto, cantidad);
            } else {
                localStorage.removeItem(sessionKey + '_cantidad_' + idProducto);
            }
        });
    }

    // Función para restaurar el estado de los inputs de cantidad desde localStorage
    function restaurarEstadoCantidad() {
        $('.cantidad').each(function() {
            var idProducto = $(this).data('id');
            var cantidad = localStorage.getItem(sessionKey + '_cantidad_' + idProducto);
            if (cantidad !== null && cantidad !== '') {
                $(this).val(cantidad);
            } else {
                $(this).val(''); // Dejar vacío si no hay cantidad almacenada
            }
        });
    }

    // Llamar a restaurarEstadoCantidad al cargar la página
    restaurarEstadoCantidad();

    // Guardar el estado al salir de la página
    $(window).on('beforeunload', function() {
        guardarEstadoCantidad();
    });

    // Evento al hacer clic en Ver Carrito
    $('#verCarrito').click(function(e) {
        // Evitar que el enlace se comporte como un enlace normal
        e.preventDefault();
        // Guardar el estado antes de redirigir
        guardarEstadoCantidad();
        // Redirigir a la página del carrito
        window.location.href = 'ruta-a-tu-carrito.php';
    });

    // Limpiar localStorage cuando se cierra sesión
    $('a.btn-danger').click(function() {
        localStorage.clear();
    });
});
</script>
</html>