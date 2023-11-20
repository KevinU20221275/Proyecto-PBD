<?php
require('conexion.bd.php');
require('config.php');

$query = mysqli_query($conexion, "SELECT * FROM `Producto`");
$result = mysqli_num_rows($query);
// session_destroy();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/style.css">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->

    <!--==================== UNICONS ====================-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Nav</title>
</head>
<body class="body">
    <header class="header" id="header">
        <nav class="nav contenedor">
            <a href="#" class="nav__logo">Logo</a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list grid">
                    <li class="nav__item">
                        <a href="#home" class="nav__link fw-600 active-link">
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
                    <li class="nav__item">
                        <a href="checkout_carrito.php" id="num_cart" class="nav__link">
                            <i class="uil uil-shopping-cart-alt">   <?php echo $num_cart; ?></i> 
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
    <section class="banner">
			<div class="content-banner">
				<p>Café Delicioso</p>
				<h2>100% Natural <br />Café Fresco</h2>
				<a href="#">Comprar ahora</a>
			</div>
	</section>

    <section class="container top-categories">
				<h1 class="heading-1">Mejores Categorías</h1>
				<div class="container-categories">
					<div class="card-category category-moca">
						<p>Café moca</p>
						<span>Ver más</span>
					</div>
					<div class="card-category category-expreso">
						<p>Expreso Americano</p>
						<span>Ver más</span>
					</div>
					<div class="card-category category-capuchino">
						<p>Capuchino</p>
						<span>Ver más</span>
					</div>
				</div>
	</section>

    <section class="container top-products">
				<h1 class="heading-1">Mejores Productos</h1>

				<div class="container-options">
					<span class="active">Destacados</span>
					<span>Más recientes</span>
					<span>Mejores Vendidos</span>
				</div>
    </section>


    <div class="container">
        <div class="container-products">
            <?php
            if ($result > 0){
                while ($data = mysqli_fetch_array($query)){
                ?>
                    <div class="card-product">
                        <div class="container-img">
                            <img src="data:image/jpg;base64, <?php echo base64_encode($data['imagen']) ?>" alt="" class="img-card">
                            <?php if($data['Descuento'] > 0) { ?>
                                <span class="discount">- <?php echo $data['Descuento']; ?>%</span>
                            <?php } else { ?>
                                
                            <?php } ?>
                        </div>
                        <div class="content-card-product">
                            <h3 class="card-title"><?php echo $data['NombreProducto'] ?></h3>
                            <p><?php echo $data['Descripcion']?></p>
                            <?php if($data['Descuento'] > 0) { ?>
                                <p><del>$ <?php echo number_format($data['Precio'],2,'.',',' );?></del></p>
                                <h2>
                                    $ <?php echo number_format($precioDescuento = $data['Precio'] - (($data['Precio'] * $data['Descuento']) / 100),2,'.',',' );?>
                                </h2>
                            <?php } else { ?>
                                <span style='padding: 10px;'></span>
                                <h2>$ <?php echo number_format($data['Precio'],2,'.',',' );?></h2>
                            <?php } ?>
                            <div class="btn-group">
                                    
                                <a href="detallesProductos.php?id=<?php echo $data['id_producto']; ?>&token=<?php echo
                                hash_hmac('sha1', $data['id_producto'], KEY_TOKEN); ?>" class="button">Detalles</a>
                                    
                                <button class="button--white" type="button" onclick="addProducto(<?php echo $data['id_producto'] ?>,
                                <?php echo hash_hmac('sha1', $data['id_producto'], KEY_TOKEN) ?>)"><i class="uil uil-shopping-cart-alt button__icon"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <!--==================== SCROLL TOP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="uil uil-arrow-up scrollup__icon"></i>
    </a>
    

    <script src="./JS/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function addProducto(id, token){
            let url = 'carrito.php'
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