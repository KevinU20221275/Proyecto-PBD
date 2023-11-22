<?php
require 'config.php';
require 'conexion.bd.php';

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (is_array($datos)){
    $id_transaccion = $datos['detalles']['id'];
    $monto = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

    $query = $conexion->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("sssssd", $id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $monto);
    $query->execute();

    $id = $conexion->insert_id;

    if ($id > 0){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if ($productos != null) {
            foreach ($productos as $clave => $cantidad){
                $query = mysqli_query($conexion, "SELECT id_producto, NombreProducto, Precio, Descuento FROM `Producto` WHERE id_producto=$clave");
                $row_productos = mysqli_fetch_array($query);
                $precio = $row_productos['Precio'];
                $descuento = $row_productos['Descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $sql_insert = $conexion->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?, ?, ?, ?, ?)");
                $sql_insert->bind_param("iisdi", $id, $clave, $row_productos['NombreProducto'], $precio_desc, $cantidad);
                $sql_insert->execute();

            }
        } 
        unset($_SESSION['carrito']);             
    }
}

?>