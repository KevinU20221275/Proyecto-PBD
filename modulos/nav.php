    <header class="header" id="header">
        <nav class="nav contenedor">
            <a href="#" class="nav__logo">
                <img src="./assets/images/logo.png" alt="" class="logo">
            </a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list grid">
                    <li class="nav__item">
                        <a href="index.php" class="nav__link fw-600 active-link">
                            <i class="uil uil-estate nav__icon"></i> Home
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#categorias" class="nav__link">
                            <i class="uil uil-user nav__icon"></i> Categorias
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="./pages/productos.php" class="nav__link">
                            <i class="uil uil-file-alt nav__icon"></i> Productos
                        </a>
                    </li>

                    <?php 
                        $usuario = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
                        ?>
                    <?php  if ($usuario != null) { ?>
                            <li class="nav__item">
                                <a href="./pages/checkout_carrito.php" id="num_cart" class="nav__link">
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
                                        <a href="./config/logout.php" class="dropdown-item nav__link">Cerrar Sesion</a>
                                    </li>
                                </ul>
                            </div>
                    <?php    } else { ?>
                            <li class="nav__item">
                                <a href="./pages/registro.php" class="nav__link">
                                    <i class="uil uil-briefcase-alt nav__icon"></i> Registrarse
                                </a>
                            </li>
                            <li class="nav__item">
                                <a href="./pages/login.php" class="nav__link">
                                    <i class="uil uil-scenery nav__icon"></i> Entrar
                                </a>
                            </li>
                            <li class="nav__item">
                                <a href="./pages/checkout_carrito.php" id="num_cart" class="nav__link">
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