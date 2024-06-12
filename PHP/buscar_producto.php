<?php
include("../SQL/connection.php");

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$query%' OR descripcion LIKE '%$query%'";
    $result = mysqli_query($conection, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr class="table-primary" id="producto-' . $row['id'] . '">';
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['descripcion']}</td>";
            echo "<td>{$row['precio']}</td>";
            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '" alt="Imagen"></td>';
            echo "<td>{$row['disponibilidad']}</td>";
            echo '<td>
                    <button class="btn btn-info btn-sm btn-ver">Ver</button>
                    <button class="btn btn-warning btn-sm btn-editar">Editar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="' . $row['id'] . '">Eliminar</button>
                </td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="7">No se encontraron productos</td></tr>';
    }
}
?>
