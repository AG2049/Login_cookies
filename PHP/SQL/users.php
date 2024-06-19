<?php
    include("connection.php");


    $usuarios = mysqli_query($conection,"SELECT * FROM usuarios");
    $userName=[];
    $passwords=[];
    while ($registro = mysqli_fetch_row($usuarios)){
        $userName[] = $registro[1];
        $passwords[] = $registro[2];
        $userType[] = $registro[3];
    }


    mysqli_free_result($usuarios);
    mysqli_close($conection);

?>