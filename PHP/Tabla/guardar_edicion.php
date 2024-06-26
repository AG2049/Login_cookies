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
    $imagenBASE64 = null;
    if (!empty($_FILES['imagen']['tmp_name'])) {
        $contenidoImagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $imagenBASE64 = base64_encode($contenidoImagen);
    }
    
    if ($id != "") {
        // Actualización de un producto existente
        $query = "UPDATE productos SET 
                  NOM_producto = '$nombre', 
                  DES_producto = '$descripcion', 
                  PREC_producto = '$precio', 
                  NO_productos_disponibles = '$disponibilidad'";
        
        if ($imagenBASE64 != null) {
            $query .= ", IMG_producto = '$imagenBASE64'";
        }
        
        $query .= " WHERE ID_producto = '$id'";
        
        $result = mysqli_query($conection, $query);
    } else {
        // Comprobamos que los campos requeridos no estén vacíos
        if ($nombre != "" && $descripcion != "" && $precio != "" && $disponibilidad != "" && $imagenBASE64 != null) {
            // Inserción de un nuevo producto
            $query = "INSERT INTO `productos` (`NOM_producto`, `DES_producto`, `PREC_producto`, `IMG_producto`, `NO_productos_disponibles`) 
                      VALUES ('$nombre', '$descripcion', '$precio', '$imagenBASE64', '$disponibilidad')";
            
            $result = mysqli_query($conection, $query);
        } else {
            echo json_encode(array('success' => 0));
            mysqli_close($conection);
            exit();
        }
    }
    
    if ($result) {
        echo json_encode(array('success' => $buttonType ? 1 : 2));
    } else {
        echo json_encode(array('success' => 0));
    }
    
    mysqli_close($conection);
    exit();
}
