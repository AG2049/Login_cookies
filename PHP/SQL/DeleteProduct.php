<?php
    include("connection.php");
    if(isset($_POST['id_producto'])){//Verificamos que se mande un POST
        $ID = $_POST['id_producto'];;//Guardamos la ID
        $DELETE_producto = mysqli_query($conection,"DELETE FROM productos WHERE ID_producto=$ID");
        header("Location: ../welcome.php");
    } else {
        echo "No se proporciono la ID del producto";
    }
    
    mysqli_close($conection);
?>