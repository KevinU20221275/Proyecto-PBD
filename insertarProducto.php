<?php 
require('conexion.bd.php');
if (empty($_POST['NombreProducto']) || empty($_POST['Descripcion'])){
    echo "Por favor llene los campos Correspondientes";
} else {
    $nombreProducto = $_POST['NombreProducto'];
    $descripcion = $_POST['Descripcion'];
    // precio a float
    $precio = $_POST['Precio'];
    $precio_float = floatval($precio);
    // stock a int
    $stock = $_POST['Stock'];
    $stock_int = intval($stock);
    // categoria a int
    $categoria = $_POST['id_Categoria'];
    $id_Categoria = intval($categoria);
    
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    $descuento = $_POST['Descuento'];
    $descuentoInt = intval($descuento);
    $query= "INSERT INTO `Producto` VALUES (@id,'$nombreProducto','$descripcion','$precio_float',$descuento,'$stock_int' , '$id_Categoria','$imagen')";
    $result = $conexion->query($query);

    if ($result) {
        echo "Se han insertado los datos";
    } else {
        echo "No se han insertado los datos";
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Agregar Producto</h1>
    <form method='POST' enctype='multipart/form-data'>
        <h1>Ingrese los datos Correspondientes</h1>
        <label for="">Nombre Producto: </label>
        <input type="text" name="NombreProducto"><br><br>
        <label for="">Descripcion: </label>
        <input type="text" name="Descripcion"><br><br>
        <label for="">Precio: </label>
        <input type="text" name="Precio"><br><br>
        <label for="">Stock: </label>
        <input type="text" name="Stock"><br><br>
        <label for="">Id_Categoria: </label>
        <input type="text" name="id_Categoria"><br><br>
        <label for="">Foto: </label>
        <input type="file" name="imagen" require><br><br>
        <label for="">Descuento: </label>
        <input type="text" name="Descuento" require><br><br>
        <input type="submit" name="Guardar" value="Guardar">
        <button><a href="index.php">Consultar</a></button>
    </form>
</body>
</html>