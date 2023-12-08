<?php
require 'config.php';
require 'conexion.bd.php';

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (is_array($datos)){

    $id_cliente = $_SESSION['user_cliente'];
    $query_cliente = mysqli_query($conexion, "SELECT email,direccion FROM `Cliente` WHERE Id=$id_cliente");
    $data_cliente = mysqli_fetch_array($query_cliente);

    $id_transaccion = $datos['detalles']['id'];
    $monto = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $data_cliente['email'];
    $direccion = $data_cliente['direccion'];
    

    $query = $conexion->prepare("INSERT INTO Compra (id_transaccion, fecha, status, email, direccion, id_cliente, total) VALUES (?, ?, ?, ?, ?, ?,?)");
    $query->bind_param("ssssssd", $id_transaccion, $fecha_nueva, $status, $email, $direccion,$id_cliente, $monto);
    $query->execute();

    $id = $conexion->insert_id;

    if ($id > 0){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if ($productos != null) {
            foreach ($productos as $clave => $cantidad){
                $query = mysqli_query($conexion, "SELECT Id, Nombre, Precio, Descuento FROM `Producto` WHERE Id=$clave");
                $row_productos = mysqli_fetch_array($query);
                $precio = $row_productos['Precio'];
                $descuento = $row_productos['Descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $sql_insert = $conexion->prepare("INSERT INTO detalle_compra (id_compra, id_producto, NombreProducto, Precio, Cantidad) VALUES (?, ?, ?, ?, ?)");
                $sql_insert->bind_param("iisdi", $id, $clave, $row_productos['Nombre'], $precio_desc, $cantidad);
                $sql_insert->execute();

            }
            header('Location: ../index.php');
             
        } 
        unset($_SESSION['carrito']); 
    }
}

?>
