<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $cantidad = intval($_POST['cantidad']);

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] = $cantidad;
    } else {
        $_SESSION['carrito'][$id_producto] = $cantidad;
    }
}
?>