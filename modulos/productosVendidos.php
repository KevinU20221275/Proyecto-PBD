<?php

$queryMasVendidos = mysqli_query($conexion, "SELECT * FROM vw_productosMas_Vendidos");

?>

<div class="container-products">
        <?php
            if ($queryMasVendidos){
                while ($productosMasVendidos = mysqli_fetch_array($queryMasVendidos)){
                ?>
                    <div class="card-product">
                        <div class="container-img">
                            <img src="data:image/jpg;base64, <?php echo base64_encode($productosMasVendidos['imagen']) ?>" alt="" class="img-card">
                            <?php if($productosMasVendidos['Descuento'] > 0) { ?>
                                <span class="discount">- <?php echo $productosMasVendidos['Descuento']; ?>%</span>
                            <?php } else { ?>
                                
                            <?php } ?>
                        </div>
                        <div>
                            <div>
                                <h3 class="card__title"><?php echo $productosMasVendidos['Nombre'] ?></h3>
                                <?php if($productosMasVendidos['Descuento'] > 0) { ?>
                                    <p><del>$ <?php echo number_format($productosMasVendidos['Precio'],2,'.',',' );?></del></p>
                                    <h2 class="text-discount">
                                        $ <?php echo number_format($precioDescuento = $productosMasVendidos['Precio'] - (($productosMasVendidos['Precio'] * $productosMasVendidos['Descuento']) / 100),2,'.',',' );?>
                                    </h2>
                                <?php } else { ?>
                                    <span></span>
                                    <h2 style="margin-top:32px; font-size:1.4rem;">$ <?php echo number_format($productosMasVendidos['Precio'],2,'.',',' );?></h2>
                                <?php } ?>
                            </div>
                            <div class="btn-group">
                                    
                                <a href="./pages/detallesProductos.php?id=<?php echo $productosMasVendidos['Id']; ?>&token=<?php echo
                                hash_hmac('sha1', $productosMasVendidos['Id'], KEY_TOKEN); ?>" class="button">Detalles</a>
                                    
                                <button class="button--white" type="button" onclick="addProducto(<?php echo $productosMasVendidos['Id'] ?>,'<?php echo hash_hmac('sha1', $productosMasVendidos['Id'], KEY_TOKEN); ?>')">
                                <i class="uil uil-shopping-cart-alt button__icon"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
</div>