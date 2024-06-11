<?php
session_start();
ini_set('display_errors',E_ALL);
include("../SQL/connection.php");

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
    $disponibilidad = $_POST['disponibilidad'];
    //Carga de la imagen
    if (!empty($_FILES['imagen']['tmp_name'])) {
        $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $imagenBASE64 = base64_encode($contenidoImagen);
        //Cargamos la Imagen si existe
        $UPDATE_product = mysqli_query($conection, "UPDATE productos SET 
        NOM_producto = '$nombre', 
        DES_producto = '$descripcion', 
        PREC_producto = '$precio', 
        IMG_producto = '$imagenBASE64', 
        NO_productos_disponibles = '$disponibilidad' 
        WHERE ID_producto = '$id'");
    } else {
        //Cargamos los demas sin alterar la imagen
        $UPDATE_product = mysqli_query($conection, "UPDATE productos SET 
        NOM_producto = '$nombre', 
        DES_producto = '$descripcion', 
        PREC_producto = '$precio',
        NO_productos_disponibles = '$disponibilidad' 
        WHERE ID_producto = '$id'");
    }

    // Redireccionar a welcome.php
    mysqli_close($conection);//Cerramos la conexion
    header("Location: ../welcome.php");
    exit();
}