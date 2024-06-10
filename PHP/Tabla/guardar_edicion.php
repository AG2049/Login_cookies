<?php
session_start();

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

    // Aquí debes incluir la lógica para guardar los cambios en la base de datos

    // Depuración
    error_log("ID: $id, Nombre: $nombre, Descripción: $descripcion, Precio: $precio");

    // Redireccionar a welcome.php
    header("Location: ../../welcome.php");
    exit();
}