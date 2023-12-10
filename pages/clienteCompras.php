<?php
require('../config/conexion.bd.php');
require('../config/config.php');

$id_cliente = $_SESSION["user_id"];

$query = mysqli_query($conexion, "SELECT * FROM `vw_compras_cliente` WHERE Id_cliente=$id_cliente ORDER BY Fecha DESC LIMIT 4");
$result = mysqli_num_rows($query);

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
                    <li class="nav__item">
                        <a href="productos.php" class="nav__link">
                            <i class="uil uil-coffee nav__icon"></i> Productos
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
                            <i class="uil uil-clipboard-alt nav__icon"></i> Registrarse
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

    <h1 class="text-center mt-5 pt-5">Todos los Productos</h1>

    <section class="container mt-4" id="productosDestacados">
        <div class="row">
        <?php
            if ($result > 0){
                while ($data = mysqli_fetch_array($query)){
                ?>
                <div class="col-sm-6 mb-3 ">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title">Compra: <?php echo $data['Id_transaccion'] ?> </h6>
                            <label for="">Fecha: <?php echo $data['Fecha'] ?></label>
                            <p class="card-text"><strong>Cliente: </strong><?php echo $data['Cliente'] ?></p>
                            <p><strong>Direccion: </strong><?php echo $data['Direccion'] ?></p>
                            <ul class="list-group list-group-flush">
                            <?php
                                $id_compra = $data['idCompra'];
                                $queryDetalle = mysqli_query($conexion, "SELECT * FROM `vw_compras_detalle_cliente` WHERE Id_compra=$id_compra");
                                $resultDetalle = mysqli_num_rows($queryDetalle);
                                if ($resultDetalle > 0){
                                    while ($dataDetalle = mysqli_fetch_array($queryDetalle)){
                                        ?>
                                        <li class="list-group-item"><?php echo $dataDetalle['NombreProducto']; ?> Cantidad: <?php echo $dataDetalle['Cantidad']; ?> Precio: <?php echo $dataDetalle['Precio']; ?> </li>
                            <?php   }
                                } else {
                                    echo 'No hay detalles de la compra';
                                }
                            ?>
                            </ul>
                            <div class="text-end">
                                <label for="">Total: $ <?php echo $data['Total'] ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php  } 
                } else {
                    echo 'No tiene Compras para Mostrar';
            }
        ?>
        </div>
    </section>

    <!--==================== FOOTER ====================-->
    <footer class="footer">
        <div class="footer__bg">
            <div class="footer__container container">
                <div class="footer__socials">
                    <a href="#" target="_blank" class="footer__social" title="Link a Facebook">
                        <i class="uil uil-facebook-f"></i>
                    </a>

                    <a href="#" target="_blank" class="footer__social" title="Link a Instagran">
                        <i class="uil uil-instagram"></i>
                    </a>

                    <a href="#" target="_blank" class="footer__social" title="Link a Twitter">
                        <i class="uil uil-twitter"></i>
                    </a>
                </div>
            </div>
            <p class="footer__copy">&copy; Diseño Web Adaptable</p>
        </div>
    </footer>

    
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