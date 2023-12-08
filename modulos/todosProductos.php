<?php
$query = mysqli_query($conexion, "SELECT * FROM `vw_productos_vista`");
$result = mysqli_num_rows($query);
?>

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
                        <div>
                            <div>
                                <h3 class="card__title"><?php echo $data['Nombre'] ?></h3>
                                <?php if($data['Descuento'] > 0) { ?>
                                    <p><del>$ <?php echo number_format($data['Precio'],2,'.',',' );?></del></p>
                                    <h2 class="text-discount">
                                        $ <?php echo number_format($precioDescuento = $data['Precio'] - (($data['Precio'] * $data['Descuento']) / 100),2,'.',',' );?>
                                    </h2>
                                <?php } else { ?>
                                    <span></span>
                                    <h2 style="margin-top:32px; font-size:1.4rem;">$ <?php echo number_format($data['Precio'],2,'.',',' );?></h2>
                                <?php } ?>
                            </div>
                            <div class="btn-group">
                                    
                                <a href="detallesProductos.php?id=<?php echo $data['id']; ?>&token=<?php echo
                                hash_hmac('sha1', $data['id'], KEY_TOKEN); ?>" class="button">Detalles</a>
                                    
                                <button class="button--white" type="button" onclick="addProducto(<?php echo $data['id'] ?>,'<?php echo hash_hmac('sha1', $data['id'], KEY_TOKEN); ?>')">
                                <i class="uil uil-shopping-cart-alt button__icon"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
</div>