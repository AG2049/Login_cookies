<?php
session_start();
include("../SQL/connection.php");

// Verificar si la sesión está iniciada
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada']);
    exit();
}

// Procesar la edición del producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponibilidad = isset($_POST['disponibilidad']) ? $_POST['disponibilidad'] : 0;
    $imagen = ''; // Asume que manejas la imagen de alguna manera

    // Depuración
    error_log("ID: $id, Nombre: $nombre, Descripción: $descripcion, Precio: $precio");

    // Verifica si el ID está vacío para determinar si es una inserción o una actualización
    if ($id) {
        // Actualizar producto existente
        $query = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen', disponibilidad='$disponibilidad' WHERE id='$id'";
    } else {
        // Agregar nuevo producto
        $query = "INSERT INTO productos (nombre, descripcion, precio, imagen, disponibilidad) VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$disponibilidad')";
    }

    if (mysqli_query($conection, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conection)]);
    }
    mysqli_close($conection);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no permitido']);
}
?>
