<?php
session_start();
ini_set('display_errors', E_ALL);
include("../SQL/connection.php");

// Redirigir a la página normal si el usuario no es administrador
if ($_SESSION['user_type'] == false) {
    header("Location: ../user/welcomeNormal.php");
    exit();
}

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../../Index.php");
    exit();
}

// Procesar la edición del producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponibilidad = intval($_POST['disponibilidad']);
    $buttonType = $_POST['guardar_continuar'];

    // Cargar la imagen si existe
    if ($id != "" && !empty($_FILES['imagen']['tmp_name'])) {
        $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $imagenBASE64 = base64_encode($contenidoImagen);
        // Actualizar el producto con la imagen
        $UPDATE_product = mysqli_query($conection, "UPDATE productos SET 
            NOM_producto = '$nombre', 
            DES_producto = '$descripcion', 
            PREC_producto = '$precio', 
            IMG_producto = '$imagenBASE64', 
            NO_productos_disponibles = '$disponibilidad' 
            WHERE ID_producto = '$id'");
    } elseif ($id != "") {
        // Actualizar el producto sin alterar la imagen
        $UPDATE_product = mysqli_query($conection, "UPDATE productos SET 
            NOM_producto = '$nombre', 
            DES_producto = '$descripcion', 
            PREC_producto = '$precio', 
            NO_productos_disponibles = '$disponibilidad' 
            WHERE ID_producto = '$id'");
    }

    // Insertar un nuevo producto
    if ($id == "" && $nombre != "" && $descripcion != "" && $precio != "" && $disponibilidad != "") {
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $imagenBASE64 = base64_encode($contenidoImagen);
            // Insertar producto con imagen
            $INSERT_product = mysqli_query($conection, "INSERT INTO productos (NOM_producto, DES_producto, PREC_producto, IMG_producto, NO_productos_disponibles) VALUES ('$nombre', '$descripcion', '$precio', '$imagenBASE64', '$disponibilidad')");
        } else {
            // Insertar producto sin imagen
            $INSERT_product = mysqli_query($conection, "INSERT INTO productos (NOM_producto, DES_producto, PREC_producto, NO_productos_disponibles) VALUES ('$nombre', '$descripcion', '$precio', '$disponibilidad')");
        }
    }

    // Redireccionar según el botón presionado
    if ($buttonType == true) {
        header("Location: ../Tabla/alta.php");
    } else {
        header("Location: ../welcome.php");
    }

    mysqli_close($conection);
    exit();
}
?>
