<?php
require('conexion.bd.php');
require('config.php');
$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_productos = array();

if ($productos != null) {
    // Obtener los IDs de los productos en el carrito
    $producto_ids = array_keys($productos);

    // Crear una cadena de marcadores de posición para la consulta IN
    $placeholders = implode(',', array_fill(0, count($producto_ids), '?'));

    // Consulta SQL para seleccionar los productos en el carrito
    $query = "SELECT id_producto, NombreProducto, Precio, Descuento FROM `Producto` WHERE id_producto IN ($placeholders)";
    
    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    // Verificar si la preparación fue exitosa
    if ($stmt) {
        // Vincular los valores a los marcadores de posición
        $stmt->bind_param(str_repeat('i', count($producto_ids)), ...$producto_ids);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener resultados
        $result = $stmt->get_result();

        // Obtener los productos y almacenarlos en $lista_productos
        while ($row = $result->fetch_assoc()) {
            $producto_id = $row['id_producto'];
            $lista_productos[$producto_id] = $row;
            $lista_productos[$producto_id]['Cantidad'] = $productos[$producto_id];
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Manejar el error de preparación
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
}

// session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/style.css">
    <!--==================== UNICONS ====================-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Tienda Online</title>
</head>
<body class="body">
<header class="header" id="header">
        <nav class="nav contenedor">
            <a href="#" class="nav__logo">Logo</a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list grid">
                    <li class="nav__item">
                        <a href="index.php" class="nav__link fw-600 active-link">
                            <i class="uil uil-estate nav__icon"></i> Home
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#about" class="nav__link">
                            <i class="uil uil-user nav__icon"></i> About
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#skills" class="nav__link">
                            <i class="uil uil-file-alt nav__icon"></i> Skills
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#services" class="nav__link">
                            <i class="uil uil-briefcase-alt nav__icon"></i> Services
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#portafolio" class="nav__link">
                            <i class="uil uil-scenery nav__icon"></i> Portafolio
                        </a>
                    </li>
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
                            $_id = $producto['id_producto'];
                            $nombre = $producto['NombreProducto'];
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
                                    <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad?>"
                                    size="5" id="cantidad_<?php echo $_id; ?>" onchange="updateCantidad(this.value, '<?php echo $_id;?>')">
                                </td>
                                <td>
                                    <div id="subtotal_<?php echo $_id?>" name="subtotal[]">
                                        <?php echo number_format($subtotal,2,'.',',');?>
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
        <div class="row">
            <div class="col-md-5 offset-md-7 d-grid gap-2">
                <button class="btn btn-primary btn-lg">Realizar Pago</button>
            </div>
        </div>
    </div>

    <!--==================== SCROLL TOP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="uil uil-arrow-up scrollup__icon"></i>
    </a>
    

    <script src="./JS/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function updateCantidad(cantidad, id){
            let url = 'updateCarrito.php'
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

                }
            })
        }
    </script>
</body>
</html>