<?php 
    include("connection.php");

    $productos = mysqli_query($conection,"SELECT * FROM productos"); //Consultamos la tabla productos de la BD 
    //Variables para cada columna
    $id_producto=[];
    $nombre_productp=[];
    $descripcion_producto=[];
    $precio_producto=[];
    $imagen_producto=[];
    $numero_disponibles=[];
    while($registro=mysqli_fetch_row($productos)){
        $id_producto[] = $registro[0];
        $nombre_producto[] = $registro[1];
        $descripcion_producto[] = $registro[2];
        $precio_producto[] = $registro[3];
        $imagen_producto[] = $registro[4];
        $numero_disponibles[] = $registro[5];
    }

    mysqli_free_result($productos);
    mysqli_close($conection);
?>