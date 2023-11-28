<?php
require('conexion.bd.php');
require('config.php');
require('productosFunciones.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/style.css">
    <!--==================== UNICONS ====================-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Taza y Tradicion</title>
</head>
<body class="body">
    <!--=============== NAV ==============-->
    <?php include('./modulos/nav.php')?>
    
    <!--=============== BANNER ==============-->
    <section class="banner">
			<div class="content-banner">
				<p>Café Delicioso</p>
				<h2>100% Natural <br />Café Fresco</h2>
				<a href="#productosDestacados">Comprar ahora</a>
			</div>
	</section>

    <!--=============== CATEGORIAS ==============-->
    <section id="categorias" class="container top-categories">
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

    <!--=============== PRODUCTOS DESTACADOS ==============-->
    <section class="container" id="productosDestacados">
        <h3 class="title-section-products">Destacados</h3>
        <?php include('./modulos/productosDestacados.php')?>
    </section>

    <!--=============== GALLERY ==============-->
    <section>
        <h3 class="title">La Excelencia es nuetro Sello</h3>
        <div class="gallery">
            <img src="images/gallery1.jpg"	alt="Gallery Img1" class="gallery-img-1"/>
            <img src="images/gallery2.jpg" alt="Gallery Img2" class="gallery-img-2"/>
            <img src="images/gallery3.jpg" alt="Gallery Img3" class="gallery-img-3"/>
            <img src="images/gallery4.jpg" alt="Gallery Img4" class="gallery-img-4"/>
            <img src="images/gallery5.jpg" alt="Gallery Img5" class="gallery-img-5"/>
        </div>
    </section>

    <!--=============== PRODUCTOS MAS VENDIDOS ==============-->
    <section class="container">
        <h3 class="title-section-products">Mejores Vendidos</h3>
        <?php include('./modulos/productosVendidos.php')?>
    </section>

    
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