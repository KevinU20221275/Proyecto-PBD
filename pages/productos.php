<?php
require('../config/conexion.bd.php');
require('../config/config.php');

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
    <title>Taza y Tradicion</title>
</head>
<body class="body">
    <!--=============== NAV ==============-->
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

    <h1 class="text-center">Todos los Productos</h1>

    <section class="container" id="productosDestacados">
        <h3 class="title-section-products">Destacados</h3>
        <?php include('../modulos/todosProductos.php')?>
    </section>

    
    <!--==================== SCROLL TOP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="uil uil-arrow-up scrollup__icon"></i>
    </a>
    

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
            }).then(res => res.json())
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