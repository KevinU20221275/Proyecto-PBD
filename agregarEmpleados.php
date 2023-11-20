<?php 
require('conexion.bd.php');
if (empty($_POST['nombres']) || empty($_POST['apellidos'])){
    echo "Por favor llene los campos Correspondientes";
} else {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    $query= "INSERT INTO `User` VALUES (@id,'$nombres','$apellidos', '$imagen')";
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
    <h1>Datos Personales</h1>
    <form method='POST' enctype='multipart/form-data'>
        <h1>Ingrese los datos Correspondientes</h1>
        <label for="">Nombre: </label>
        <input type="text" name="nombres"><br><br>
        <label for="">Apellidos: </label>
        <input type="text" name="apellidos"><br><br>
        <label for="">Foto: </label>
        <input type="file" name="imagen" require><br><br>
        <input type="submit" name="Guardar" value="Guardar">
        <button><a href="consultarEmpleado.php">Consultar</a></button>
    </form>
</body>
</html>