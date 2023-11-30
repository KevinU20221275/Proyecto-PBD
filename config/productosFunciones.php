
<?php
require('conexion.bd.php');
function obtenerProductosMasRecientes() {
    // Aquí deberías escribir la lógica para obtener los productos más recientes desde la base de datos
    // y devolver la información en el formato que desees (puede ser HTML, JSON, etc.).
    // Puedes reutilizar parte de tu código existente para obtener los productos.
    // Por ejemplo:
    require('conexion.bd.php');
    $query = mysqli_query($conexion, "SELECT a.Id,a.Nombre,a.Precio,COUNT(b.Id_producto) as cantidad FROM `producto` as a inner join detalle_de_compra as b on a.id=b.Id_producto GROUP by a.Nombre, b.Id_producto ORDER by count(b.Id_producto) DESC LIMIT 4;");
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

