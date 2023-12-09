<?php
require('config.php');
require 'conexion.bd.php';


if (isset($_POST['action'])){
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if ($action == 'agregar'){
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = add($id, $cantidad);
        if ($respuesta > 0) {
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }
        $datos['sub'] = '$'. number_format($respuesta,2,'.',',' );  
    } else if ($action == 'eliminar'){
        $datos['ok'] = eliminar($id);
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}


echo json_encode($datos);


function add($id, $cantidad){
    $res = 0;
    if ($id > 0 && $cantidad > 0 && is_numeric(($cantidad))){
        if(isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] = $cantidad;

            $conexion = new mysqli("localhost","root","","tienda_Online","3306");
            $query = mysqli_query($conexion, "SELECT Precio, Descuento FROM `vw_productos_vista` WHERE id=$id LIMIT 1");
            $data = mysqli_fetch_array($query);
            $precio = $data['Precio'];
            $descuento = $data['Descuento'];
            $precioDescuento = $precio - (($precio * $descuento) / 100);
            $res = $cantidad * $precioDescuento;

            return $res;
        }   
    } else {
        return $res;
    }
}

function eliminar($id){
    if($id > 0) {
        if(isset($_SESSION['carrito']['productos'][$id])){
            unset($_SESSION['carrito']['productos'][$id]);
            return true;
        } else {
            return false;
        }
    }
}
?>

