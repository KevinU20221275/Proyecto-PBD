<?php
require('config.php');
require('conexion.bd.php');


if (isset($_POST)){
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if ($action == 'agregar'){
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = add($id, $cantidad);
        $datos = array();
        if ($respuesta > 0) {
            $datos['ok'] = true;
            $datos['sub'] = '$' . numfmt_format($respuesta, 2, '.', ',');
        } else {
            $datos['ok'] = false;
        };
        
    } else{
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

            $query = mysqli_query($conexion, "SELECT Precio, Descuento FROM `Producto` WHERE id_producto=$id LIMIT 1");
            mysqli_stmt_bind_param($query, "i", $id);
            mysqli_stmt_execute($query);
            $data = mysqli_fetch_array($query);
            $precio = $data['Precio'];
            $descuento = $data['Descuento'];
            $precioDescuento = $precio - (($precio * $descuento) / 100);
            $res = $cantidad * $precioDescuento;

            return $res;
        } else {
            return $res;
        }
        
    } else {
        return $res;
    }

    
};
?>

