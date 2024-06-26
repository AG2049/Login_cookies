<?php
session_start();
header('Content-Type: application/json');
include("../SQL/connection.php");

if ($_SESSION['user_type'] == false) {
    header("Location: ../user/welcomeNormal.php");
    exit();
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

    // Directorio donde se guardarán las imágenes
    $directorio = "../../IMG/Productos/";
    $imagenRutaBD = null;

    if (!empty($_FILES['imagen']['tmp_name'])) {
        $imagenNombre = basename($_FILES['imagen']['name']);
        $imagenRuta = $directorio . $imagenNombre;

        // Mover la imagen subida al directorio
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenRuta)) {
            $imagenRutaBD = "IMG/Productos/" . $imagenNombre;
        } else {
            echo json_encode(array('success' => 0, 'message' => 'Error al subir la imagen.'));
            exit();
        }
    }

    if ($id != "") {
        // Actualización de un producto existente
        $query = "UPDATE productos SET 
                  NOM_producto = '$nombre', 
                  DES_producto = '$descripcion', 
                  PREC_producto = '$precio', 
                  NO_productos_disponibles = '$disponibilidad'";
        
        if ($imagenRutaBD != null) {
            $query .= ", IMG_producto = '$imagenRutaBD'";
        }
        
        $query .= " WHERE ID_producto = '$id'";
        
        $result = mysqli_query($conection, $query);
    } else {
        // Comprobamos que los campos requeridos no estén vacíos y que se haya cargado una imagen
        if ($nombre != "" && $descripcion != "" && $precio != "" && $disponibilidad != "" && $imagenRutaBD != null) {
            // Inserción de un nuevo producto
            $query = "INSERT INTO `productos` (`NOM_producto`, `DES_producto`, `PREC_producto`, `IMG_producto`, `NO_productos_disponibles`) 
                      VALUES ('$nombre', '$descripcion', '$precio', '$imagenRutaBD', '$disponibilidad')";
            
            $result = mysqli_query($conection, $query);
        } else {
            echo json_encode(array('success' => 0, 'message' => 'Todos los campos son requeridos y una imagen debe ser cargada.'));
            mysqli_close($conection);
            exit();
        }
    }
    
    if ($result) {
        echo json_encode(array('success' => $buttonType ? 1 : 2));
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Error al procesar la solicitud.'));
    }
    
    mysqli_close($conection);
    exit();
}
?>
