<?php

function campoNulo(array $campos){
    foreach ($campos as $campo){
        if (strlen(trim($campo)) < 1){
            return true;
        }
        return false;
    }
}

function validarPassword($password, $repassword){
    if (strcmp($password, $repassword) === 0){
        return true;
    }
    return false;
}

function generarToken(){
    return md5(uniqid(mt_rand(), false));
}


function registrarClientes(array $datos, $conexion){
    $query = $conexion->prepare("CALL sp_InsertarCliente (?, ?, ?, ?,?,?)");
    $query->bind_param("ssssss", ...$datos);
    if($query->execute()){
        return $id = $conexion->query("SELECT @id_cliente")->fetch_row()[0];
    }
    return 0;
}

function registrarUsuario(array $datos, $conexion){
    $query = $conexion->prepare("CALL sp_InsertarUsuario (?, ?, ?, ?)");
    $query->bind_param("ssss", ...$datos);
    if($query->execute()){
        return true;
    }
    return false;
}
// si el usuario ya existe

function validarUsuario($usuario, $conexion){
    $query = $conexion->prepare("SELECT id FROM usuarios WHERE NombreUsuario LIKE ? LIMIT 1");
    $usuario = "%" . $usuario . "%"; // Agregamos los comodines % al valor de usuario
    $query->bind_param("s", $usuario);
    $query->execute();
    $query->store_result();  // Almacenamos el resultado para poder obtener el número de filas
    if ($query->num_rows > 0){
        return true;
    }
    return false;
}



function mostrarErrores(array $errors){
    if (count($errors) > 0){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul>';
        foreach($errors as $error){
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button></div>';
        
    }
}

function loginUsuario($usuario, $password, $conexion, $proceso){
    $query = $conexion->prepare("SELECT id, NombreUsuario, password, id_cliente FROM Usuarios WHERE NombreUsuario LIKE ? LIMIT 1");
    $usuario = "%" . $usuario . "%";
    $query->bind_param("s", $usuario);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0){
        $query->bind_result($id, $NombreUsuario, $hashed_password, $id_cliente);
        $query->fetch();

        if (password_verify($password, $hashed_password)){
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $NombreUsuario;
            $_SESSION['user_cliente'] = $id_cliente;
            if ($proceso == 'pago') {
                header("Location: pago.php");
            } else {
                header("Location: ../index.php");
                exit;
            }
        } else {
            return 'Usuario o Contraseña incorrectos';
        }
    } else {
        return 'Usuario o Contraseña incorrectos';
    }
}

?>