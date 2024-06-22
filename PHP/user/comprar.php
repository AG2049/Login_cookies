<?php
session_start();
include("../SQL/products.php");

// Verificar si se ha enviado un formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluir archivo de conexión a la base de datos
    include("../SQL/connection.php");

    foreach ($_SESSION['carrito'] as $id_producto_carrito => $cantidad) {
        // Actualizar la disponibilidad en la base de datos
        $index = array_search($id_producto_carrito, $id_producto);
        if ($index !== false) {
            $nuevo_stock = $numero_disponibles[$index] - $cantidad;
            $query = "UPDATE productos SET NO_productos_disponibles = $nuevo_stock WHERE ID_producto = $id_producto_carrito";
            mysqli_query($conection, $query);
        }
    }

    // Vaciar el carrito
    $_SESSION['carrito'] = array();

    // Redirigir a una página de confirmación
    header("Location: confirmacion.php");
    exit();
} else {
    // Si no es una solicitud POST, redirigir a alguna página adecuada
    header("Location: welcomeNormal.php");
    exit();
}
?>