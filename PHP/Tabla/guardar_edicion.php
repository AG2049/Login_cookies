<?php
session_start();
header('Content-Type: application/json');
include("../SQL/connection.php");

if($_SESSION['user_type']==false){
    header("Location: ../user/welcomeNormal.php");
}
// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
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
        if($buttonType==true){
            echo json_encode(array('success' => 1));
            mysqli_close($conection);
            exit();
        }else{
            echo json_encode(array('success' => 2));
            mysqli_close($conection);
            exit();
        }
    } else {
        //Cargamos los demas sin alterar la imagen
        $UPDATE_product = mysqli_query($conection, "UPDATE productos SET 
        NOM_producto = '$nombre', 
        DES_producto = '$descripcion', 
        PREC_producto = '$precio',
        NO_productos_disponibles = '$disponibilidad' 
        WHERE ID_producto = '$id'");
        if($buttonType==true){
            echo json_encode(array('success' => 1));
            mysqli_close($conection);
            exit();
        }else{
            echo json_encode(array('success' => 2));
            mysqli_close($conection);
            exit();
        }
    }
    //Comprobamos que no exista ID para agregar un nuevo producto
    if($id=="" && $nombre!="" && $descripcion!="" && $precio!="" && $disponibilidad!=""){
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $imagenBASE64 = base64_encode($contenidoImagen);
            $INSERT_product = mysqli_query($conection, "INSERT INTO `productos` (`ID_producto`,`NOM_producto`, `DES_producto`, `PREC_producto`, `IMG_producto`, `NO_productos_disponibles`) VALUES (NULL,'$nombre', '$descripcion',$precio,'$imagenBASE64',$disponibilidad)");
        }else{
            echo json_encode(array('success' => 0));
            exit();
        }
    }else{
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $imagenBASE64 = base64_encode($contenidoImagen);
            $INSERT_product = mysqli_query($conection, "INSERT INTO `productos` (`ID_producto`,`NOM_producto`, `DES_producto`, `PREC_producto`, `IMG_producto`, `NO_productos_disponibles`) VALUES (NULL,'$nombre', '$descripcion',$precio,'$imagenBASE64',$disponibilidad)");
        }
        echo json_encode(array('success' => 0));
        exit();
    }
    // Redireccionar a welcome.php
    if($buttonType==true){
        echo json_encode(array('success' => 1));
        mysqli_close($conection);
    }else{
        echo json_encode(array('success' => 2));
        mysqli_close($conection);
        exit();
    }
    
} 