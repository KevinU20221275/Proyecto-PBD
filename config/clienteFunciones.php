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
    $sql = "CALL sp_LoginUsuario (?, @user_id, @user_name, @hashed_password, @user_cliente, @contador);";
    $query = $conexion->prepare($sql);
    $query->bind_param("s", $usuario);
    $query->execute();

    $result = $conexion->query("SELECT @user_id AS user_id, @user_name as user_name,@hashed_password AS hashed_password ,@user_cliente AS user_cliente,@contador AS contador");
    $row = $result->fetch_assoc();

    $contador = isset($row['contador']) ? $row['contador'] : 0;
    $id = $row['user_id'];
    $NombreUsuario = $row['user_name'];
    $hashed_password = $row['hashed_password'];
    $id_cliente = $row['user_cliente'];


    if ($contador > 0){
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
        $query->close();
    }
    
    $conexion->close();
}

?>