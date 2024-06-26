<?php
session_start();
include("../SQL/products.php");

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Incluir CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/carrito.css">
</head>
<body>
<div class="container mt-5">
    <h1>Carrito de Compras</h1>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalCompra = 0;
            $cantidadesExcesivas = false; // Variable para controlar si hay cantidades excesivas

            foreach ($_SESSION['carrito'] as $id_producto_carrito => $cantidad) {
                // Buscar el índice del producto en el array $id_producto
                $index = array_search($id_producto_carrito, $id_producto);
                if ($index !== false) {
                    // Calcular el subtotal del producto
                    $subtotal = $precio_producto[$index] * $cantidad;
                    $totalCompra += $subtotal;

                    // Verificar si la cantidad en el carrito es mayor que la disponibilidad
                    if ($cantidad > $numero_disponibles[$index]) {
                        $cantidadesExcesivas = true;
                    }

                    // Mostrar el producto solo si la cantidad en el carrito es mayor que 0
                    if ($cantidad > 0) {
                        echo '<tr>';
                        echo '<td><img src="data:image/jpeg;base64,' . $imagen_producto[$index] . '" alt="Imagen"></td>';
                        echo "<td>{$nombre_producto[$index]}</td>";
                        echo "<td>{$cantidad}</td>";
                        echo "<td>$ {$precio_producto[$index]}</td>";
                        echo "<td>$ {$subtotal}</td>";
                        echo '</tr>';
                    }
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Mostrar el total de la compra -->
    <div class="alert alert-info" role="alert">
        Total de la compra: $ <?php echo number_format($totalCompra, 2); ?>
    </div>

    <!-- Mostrar mensaje de error si hay cantidades excesivas -->
    <?php if ($cantidadesExcesivas): ?>
        <div class="alert alert-danger">Uno o más productos tienen una cantidad mayor a su disponibilidad</div>
    <?php else: ?>
        <!-- Mostrar el botón de compra si no hay cantidades excesivas -->
        <form action="comprar.php" method="POST">
            <button type="submit" class="btn btn-success">Comprar</button>
        </form>
    <?php endif; ?>

</div>
</body>
<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir JS de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>