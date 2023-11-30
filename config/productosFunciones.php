
<?php
require('conexion.bd.php');
function obtenerProductosMasRecientes() {
    require('conexion.bd.php');
    $query = mysqli_query($conexion, "SELECT a.Id,a.Nombre,a.Precio,COUNT(b.Id_producto) as cantidad FROM `producto` as a inner join detalle_compra as b on a.id=b.Id_producto GROUP by a.Nombre, b.Id_producto ORDER by count(b.Id_producto) DESC LIMIT 4;");
    $resultados = array();

    while ($data = mysqli_fetch_array($query)) {
        $resultados[] = $data;
    }

    return json_encode($resultados);
}

// Verificar si la solicitud es mediante AJAX y ejecutar la función si es así
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo obtenerProductosMasRecientes();
} else {
    echo "Acceso denegado";
}
?>

