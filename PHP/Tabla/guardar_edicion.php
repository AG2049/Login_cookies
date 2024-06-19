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
    $disponibilidad = intval($_POST['disponibilidad']);
    $buttonType = $_POST['guardar_continuar'];
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
    //Comprobamos que no exista ID para agregar un nuevo producto
    if($id=="" && $nombre!="" && $descripcion!="" && $precio!="" && $disponibilidad!=""){
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $imagenBASE64 = base64_encode($contenidoImagen);
            //Preparamos la consulta
            $INSERT_product = mysqli_query($conection, "INSERT INTO `productos` (`ID_producto`,`NOM_producto`, `DES_producto`, `PREC_producto`, `IMG_producto`, `NO_productos_disponibles`) VALUES (NULL,'$nombre', '$descripcion',$precio,'$imagenBASE64',$disponibilidad)");
        }
    }
    // Redireccionar a welcome.php
    if($buttonType==true){
        header("Location: ../Tabla/alta.php");
        mysqli_close($conection);
    }else{
        mysqli_close($conection);
        header("Location: ../welcome.php");
        exit();
    }
    
} 