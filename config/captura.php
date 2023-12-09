<?php
require 'config.php';
require 'conexion.bd.php';

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (is_array($datos)){

    $id_cliente = $_SESSION['user_cliente'];
    $query_cliente = mysqli_query($conexion, "SELECT Email,Direccion FROM `vw_cliente_CRUD` WHERE id=$id_cliente");
    $data_cliente = mysqli_fetch_array($query_cliente);

    $id_transaccion = $datos['detalles']['id'];
    $monto = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $data_cliente['Email'];
    $direccion = $data_cliente['Direccion'];
    

    $query = $conexion->prepare("CALL sp_InsertarCompra (?, ?, ?, ?, ?, ?,?)");
    $query->bind_param("ssssssd", $id_transaccion, $fecha_nueva, $status, $email, $direccion,$id_cliente, $monto);
    $query->execute();

    $id = $conexion->query("SELECT @id_compra")->fetch_row()[0];

    if ($id > 0){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if ($productos != null) {
            foreach ($productos as $clave => $cantidad){
                $query = mysqli_query($conexion, "SELECT id, Nombre, Precio, Descuento FROM `vw_productos_vista` WHERE id=$clave");
                $row_productos = mysqli_fetch_array($query);
                $precio = $row_productos['Precio'];
                $descuento = $row_productos['Descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $sql_insert = $conexion->prepare("CALL sp_InsertarDetalleCompra (?, ?, ?, ?, ?)");
                $sql_insert->bind_param("iisdi", $id, $clave, $row_productos['Nombre'], $precio_desc, $cantidad);
                $sql_insert->execute();

            }
            header('Location: ../index.php');
             
        } 
        unset($_SESSION['carrito']); 
    }
}

?>
