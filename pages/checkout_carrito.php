<?php
require('../config/config.php');
require('../config/conexion.bd.php');
$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_productos = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad){
        $query = mysqli_query($conexion, "SELECT id, Nombre, Precio, Descuento,$cantidad AS Cantidad FROM `vw_productos_vista` WHERE id=$clave");
        $lista_productos[] = mysqli_fetch_array($query);
    }
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
                            <i class="uil uil-coffee nav__icon"></i> Productos
                        </a>
                    </li>
            <?php 
                $usuario = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
                ?>
            <?php  if ($usuario != null) { ?>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="uil uil-user"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <p><?php echo $usuario ?></p>
                            <li class="nav__item">
                                <a href="../config/logout.php" class="dropdown-item nav__link">Cerrar Sesion</a>
                            </li>
                            <li class="nav__item">
                                <a href="clienteCompras.php" class="dropdown-item nav__link">Mis Compras</a>
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
                            <i class="uil uil-signin nav__icon"></i> Entrar
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

    <div class="container pt-md-5">
        <div class="table-responsive pt-md-5">
            <table class="table">
                <thead>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php if($lista_productos == null){
                        echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>"';
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
                                <td>$ <?php echo number_format($precio_desc,2,'.',',');?></td>
                                <td>
                                    <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="updateCantidad(this.value,<?php echo $_id;?>)">
                                </td>
                                <td>
                                    <div id="subtotal_<?php echo $_id?>" name="subtotal[]">
                                        $ <?php echo number_format($subtotal,2,'.',',');?>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" id="delete" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>"
                                    data-bs-toggle="modal" data-bs-target="#modalDelete">Eliminar</a>
                                </td>
                            </tr>
                        <?php }; ?>

                        <tr>
                            <td colspan="3"></td>
                            <td colspan="4">
                                <p class="h3" id="total">
                                    <?php echo number_format($total,2,'.',','); ?>
                                </p>
                            </td>
                        </tr>
                        
                    <?php }; ?>
                </tbody>
            </table>
        </div>
        <?php if ($lista_productos != null) { ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <?php if (isset($_SESSION['user_cliente'])) { ?>
                        <a href="pago.php" class="btn btn-primary btn-lg">Realizar Pago</a>
                    <?php } else {?>
                        <a href="login.php?pago" class="btn btn-primary btn-lg">Realizar Pago</a>
                    <?php } ?>
                </div>
            </div>
        <?php }?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalDeleteLabel">Atencion!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Eliminar Producto de la Lista?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button id="btn-Delete" type="button" class="btn btn-danger" onclick="deleteProductoLista()">Eliminar</button>
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

    <script>
        let eliminarModal = document.getElementById('modalDelete')
        eliminarModal.addEventListener('show.bs.modal', (e)=>{
            let button = e.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let btnDelete = eliminarModal.querySelector('.modal-footer #btn-Delete')
            btnDelete.value = id
        })

        function updateCantidad(cantidad, id){
            let url = '../config/updateCarrito.php'
            let formData = new FormData()
            formData.append('action', 'agregar')
            formData.append('id', id)
            formData.append('cantidad', cantidad)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(res => res.json())
            .then(data => {
                if(data.ok){
                    let subtotal = document.getElementById('subtotal_'+id)
                    subtotal.innerHTML = data.sub

                    let total = 0.00
                    let list = document.getElementsByName('subtotal[]')

                    for (let i = 0; i < list.length; i++){
                        total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                    }

                    total = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2
                    }).format(total)

                    document.getElementById('total').innerHTML = '$' + total

                }
            })
        }

        function deleteProductoLista(){
            let btnEliminar = document.getElementById('btn-Delete')
            let id = btnEliminar.value
            let url = '../config/updateCarrito.php'
            let formData = new FormData()
            formData.append('action', 'eliminar')
            formData.append('id', id)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(res => res.json())
            .then(data => {
                if (data.ok){
                    location.reload()
                }
            })
        }
    </script>
</body>
</html>