<?php
function generarToken(){
    return md5(uniqid(mt_rand(), false));
}


function registrarClientes(array $datos, $conexion){
    $query = $conexion->prepare("INSERT INTO cliente (Nombres, Apellidos, Email, Telefono, DUI, Estatus, fecha_alta) VALUES (?, ?, ?, ?, ?,?,?)");
    $query->bind_param("sssssis", ...$datos);
    if($query->execute()){
        return $id = $conexion->insert_id;
    }
    return 0;
}

function registrarUsuario(array $datos, $conexion){
    $query = $conexion->prepare("INSERT INTO Usuarios (NombreUsuario, password, token, id_cliente) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssss", ...$datos);
    if($query->execute()){
        return true;
    }
    return false;
}
?>