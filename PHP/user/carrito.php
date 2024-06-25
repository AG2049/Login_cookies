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
    <style>
        /* CSS personalizado para mejorar la presentación de la tabla */
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .table img {
            max-width: 50px;
            height: auto;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table td {
            padding: 15px;
        }
        .container {
            max-width: 800px;
        }
        .alert-info {
            text-align: center;
        }
        .btn-success {
            display: block;
            width: 100%;
            font-size: 20px;
            padding: 50px;
        }
    </style>
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
                $cantidadesExesivas = 0; 
                $totalCompra = 0;
                foreach ($_SESSION['carrito'] as $id_producto_carrito => $cantidad) {
                    $index = array_search($id_producto_carrito, $id_producto);
                    if($cantidad>$numero_disponibles[$index]){
                        $cantidadesExesivas = 1;
                    }
                    if ($index !== false) {
                        $subtotal = $precio_producto[$index] * $cantidad;
                        $totalCompra += $subtotal;
                        echo '<tr>';
                        echo '<td><img src="data:image/jpeg;base64,' . $imagen_producto[$index] . '" alt="Imagen"></td>';
                        echo "<td>{$nombre_producto[$index]}</td>";
                        echo "<td>{$cantidad}</td>";
                        echo "<td>$ {$precio_producto[$index]}</td>";
                        echo "<td>$ {$subtotal}</td>";
                        echo '</tr>';
                    }
                }
            ?>
        </tbody>
    </table>
    <div class="alert alert-info" role="alert">
        Total de la compra: $ <?php echo number_format($totalCompra, 2); ?>
    </div>
    <form action="comprar.php" method="POST">
        <?php 
            if($cantidadesExesivas==0){
                echo '<button type="submit" class="btn btn-success">Comprar</button>';
            }else{
                echo '<div class="alert alert-danger">Uno o más productos tienen una cantidad mayor a su disponibilidad</div>';
                unset($_SESSION['carrito']);
            }
        ?>
    </form>
</div>
</body>
<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir JS de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
