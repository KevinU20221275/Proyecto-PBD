<?php
require('../config/conexion.bd.php');
require('../config/config.php');
$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_productos = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad){
        $query = mysqli_query($conexion, "SELECT id, Nombre, Precio, Descuento,$cantidad AS Cantidad FROM `vw_productos_vista` WHERE id=$clave");
        $lista_productos[] = mysqli_fetch_array($query);
    }
} else {
    header("location: ../index.php");
    exit;
}
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

    <div class="container pt-2 pt-md-5">
        <div class="row">
            <div class="col-6 pt-5">
                <h4>Detalles de Pago</h4>
                <div id="paypal-button-container"></div>
            </div>
            <div class="col-6">
                <div class="table-responsive pt-5">
                    <table class="table">
                        <thead>
                            <th>Producto</th>
                            <th>Subtotal</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php if($lista_productos == null){
                                echo '"<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>"';
                            } else {
                                $total = 0;
                                foreach($lista_productos as $producto){
                                    $_id = $producto['id'];
                                    $nombre = $producto['Nombre'];
                                    $precio = $producto['Precio'];
                                    $descuento = $producto['Descuento'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $cantidad = $producto['Cantidad'];
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;
                                ?>
                                    <tr>
                                        <td><?php echo $nombre?></td>

                                        <td>
                                            <div id="subtotal_<?php echo $_id?>" name="subtotal[]">
                                                <?php echo number_format($subtotal,2,'.',',');?>
                                            </div>
                                        </td>

                                    </tr>
                                <?php }; ?>

                                <tr>
                                    <td colspan="4">
                                        <p class="h3 text-end" id="total">
                                             <?php echo number_format($total,2,'.',','); ?>
                                        </p>
                                    </td>
                                </tr>
                                
                            <?php }; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--==================== SCROLL TOP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="uil uil-arrow-up scrollup__icon"></i>
    </a>

    <script src="../assets/JS/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRECY; ?>"></script>
    <script>
        var valorTotal = document.getElementById("total");
        var total = parseFloat(valorTotal.innerHTML);
        console.log(total)
        paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: `${total}`
                        }
                    }]
                })
            },
            onApprove: function(data, actions){
                let URL = '../config/captura.php'
                actions.order.capture().then(function (detalles){
                    console.log(detalles)

                    let url = '../config/captura.php'
                    return fetch(url, {
                        method: 'POST',
                        header: {
                            'content-type':'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    })
                })
            }
            ,
            onCancel: function(data){
                alert('Pago cancelado')
            }
        }).render('#paypal-button-container')
    </script>
</body>
</html>