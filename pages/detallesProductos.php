<?php 
require('../config/config.php');
require('../config/conexion.bd.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'No se pudo procesar la peticion';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if ($token === $token_tmp) {
        $query = mysqli_query($conexion, "SELECT COUNT(id) FROM `vw_productos_vista` WHERE id=$id");
        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $query = mysqli_query($conexion, "SELECT * FROM `vw_productos_vista` WHERE id=$id LIMIT 1");
            $data = mysqli_fetch_array($query);
            $nombreProducto = $data['Nombre'];
            $descripcion = $data['Descripcion'];
            $precio = $data['Precio'];
            $imagen = $data['imagen'];
            $descuento = $data['Descuento'];
            $precioDescuento = $precio - (($precio * $descuento) / 100);
        } else {
            # code...
        };
    } else {
        echo 'No se pudo procesar la peticion';
        exit;
    };
    
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/CSS/style.css">
    <link rel="stylesheet" href="../assets/CSS/theme.css">
    <!--==================== UNICONS ====================-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Tienda Online</title>
</head>
<body class="body">
    <header class="header" id="header">
        <nav class="nav contenedor">
            <a href="#" class="nav__logo">
                <img src="../assets/images/logo.png" alt="" class="logo">
            </a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list grid">
                    <li class="nav__item">
                        <a href="../index.php" class="nav__link fw-600 active-link">
                            <i class="uil uil-estate nav__icon"></i> Home
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="productos.php" class="nav__link">
                            <i class="uil uil-file-alt nav__icon"></i> Productos
                        </a>
                    </li>
            <?php 
                $usuario = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
                ?>
            <?php  if ($usuario != null) { ?>
                    <li class="nav__item">
                        <a href="checkout_carrito.php" id="num_cart" class="nav__link">
                            <i class="uil uil-shopping-cart-alt"> <?php echo  $num_cart; ?> </i>
                        </a>
                    </li>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="uil uil-user"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <p><?php echo $usuario ?></p>
                            <li class="nav__item">
                                <a href="../config/logout.php" class="dropdown-item nav__link">Cerrar Sesion</a>
                            </li>
                        </ul>
                    </div>
            <?php    } else { ?>
                    <li class="nav__item">
                        <a href="registro.php" class="nav__link">
                            <i class="uil uil-briefcase-alt nav__icon"></i> Registrarse
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="login.php" class="nav__link">
                            <i class="uil uil-scenery nav__icon"></i> Entrar
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="checkout_carrito.php" id="num_cart" class="nav__link">
                            <i class="uil uil-shopping-cart-alt"> <?php echo  $num_cart; ?> </i>
                        </a>
                    </li>
            <?php } ?>
                </ul>
                <i class="uil uil-times nav__close " id="nav-close"></i>
            </div>
            <div class="nav__btns">
                <!-- Cambiar thema -->
                <i class="uil uil-moon change-theme" id="theme-button"></i>

                <div class="nav__toggle" id="nav-toggle">
                    <i class="uil uil-apps"></i>
                </div>
            </div>
        </nav>
    </header>

    <main class="mt-md-5">
        <div class="container pt-md-4">
            <div class="row container d-flex space-around">
                <div class="col-md-6 order-md-1">
                    <img src="data:image/jpg;base64, <?php echo base64_encode($data['imagen']) ?>" alt="">
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombreProducto; ?></h2>
                    <?php if($descuento > 0) { ?>
                        <p><del>$ <?php echo number_format($precio,2,'.',',' );?></del></p>
                        <h2>
                            $ <?php echo number_format($precioDescuento,2,'.',',' );?>
                            <small class="text-success"><?php echo $descuento; ?>% de Descuento</small>
                        </h2>
                    <?php } else { ?>
                        <h2>$ <?php echo number_format($precio,2,'.',',' );?></h2>
                    <?php } ?>
                    <p class="lead">
                        <?php echo $descripcion; ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar Ahora</button>
                        <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $id; ?>,
                        '<?php echo $token; ?>')">Agregar al Carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    

    <script src="../assets/JS/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function addProducto(id, token){
            let url = '../config/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            })
            .then(res => res.json())
            .then(data => {
                if(data.ok){
                    let indicador = document.getElementById("num_cart")
                    indicador.innerHTML = data.numero
                }
            })
        }
    </script>
</body>
</html>