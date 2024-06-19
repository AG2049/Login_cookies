<?php
include("connection.php");

// Habilitar reporte de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_producto'])) {
        $id_producto = $_POST['id_producto'];
        $query = "DELETE FROM productos WHERE ID_producto = '$id_producto'";
        if (mysqli_query($conection, $query)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el registro de la base de datos.']);
        }
        mysqli_close($conection);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de producto no especificado.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>