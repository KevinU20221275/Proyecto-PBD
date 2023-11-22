<?php 
define("KEY_TOKEN", "KE.040.722");
define("CLIENT_ID", "AaCgAYzdP-cNcfqOyveGX2QlXv91RQ8mMvYsfR1hH6eGyRfUC6Ntgp912ASkWhUjE5v2Zl99d5WhqX3y");
define("CURRECY", "USD");
session_start();
$num_cart = 0;
if (isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
};
?>