<?php
include("connection.php");

if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $query = "DELETE FROM productos WHERE id = '$id_producto'";
    if (mysqli_query($conection, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
    mysqli_close($conection);
}
?>
