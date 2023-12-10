<?php
require '../config/conexion.bd.php';
require '../config/config.php';
require '../config/clienteFunciones.php';

$errors = [];
if (!empty($_POST)){
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $fecha_alta = date('Y-m-d H:i:s');
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (campoNulo([$nombres, $apellidos, $email, $telefono, $direccion, $fecha_alta, $password, $repassword])){
        $errors []= "Debe llenar todos los campos";
    };

    if (!validarPassword($password , $repassword)){
        $errors[] = "Las contraseñas no coinciden";
    }

    if (validarUsuario($usuario , $conexion)){
        $errors[] = "El nombre de usuario ya existe";
    }

    if (count($errors) == 0){
        $id = registrarClientes([$nombres, $apellidos, $email, $telefono, $direccion, $fecha_alta], $conexion);
        if ($id > 0){
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $token = generarToken();
            if(!registrarUsuario([$usuario, $pass_hash, $token, $id], $conexion)){
                $errors[] = "Error al registrar Usuario";
            } else {
                header("Location: ../index.php");
            }
        }else {
            $errors[] = "Error al registrar Cliente";
        }
        
    } 
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..assets/CSS/style.css">
    <link rel="stylesheet" href="..assets/CSS/theme.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/CSS/style.css">
    <!--==================== UNICONS ====================-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Taza y Tradicion</title>
</head>
<body class="body">
    

    <main class=" mt-5 mb-md-4 pt-md-5">
        <div class="container registro p-3 rounded-2">
            <h2>Registro de Cliente</h2>
            <?php mostrarErrores($errors); ?>
            <form action="registro.php" class="row g-3 " method="post" autocomplete="off">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-danger">*</span>Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" requireda>
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger">*</span>Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" requireda>
                </div>
                <div class="col-md-6">
                    <label for="email"><span class="text-danger">*</span>Correo Electronico</label>
                    <input type="email" name="email" id="email" class="form-control" requireda>
                </div>
                <div class="col-md-6">
                    <label for="telefono"><span class="text-danger">*</span>Telefono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" requireda>
                </div>
                <div class="col-md-6">
                    <label for="direccion"><span class="text-danger">*</span>Direccion</label>
                    <input type="text" name="direccion" id="direccion" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger">*</span>Nombre de Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" requireda>
                </div>
                <div class="col-md-6">
                    <label for="password"><span class="text-danger">*</span>Password</label>
                    <input type="password" name="password" id="password" class="form-control" requireda>
                </div>
                <div class="col-md-6">
                    <label for="repassword"><span class="text-danger">*</span>Repetir Password</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" requireda>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
    </main>

    <!--==================== SCROLL TOP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="uil uil-arrow-up scrollup__icon"></i>
    </a>
    

    <script src="../assets/JS/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>