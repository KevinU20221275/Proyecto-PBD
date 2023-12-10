<?php
require "conexion.bd.php";
session_start();

$id_producto = $_POST['id'];
echo "ID Producto: $id_producto";

$id_cliente = $_SESSION['user_id'];
$comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);
$calificacion = intval($_POST['calificacion']);
$fecha_registro = date('Y-m-d H:i:s');

$queryInsertarComentario = $conexion->prepare("CALL sp_InsertarComentario_ClienProduc (?, ?, ?, ?, ?)");
$queryInsertarComentario->bind_param("iisis", $id_producto, $id_cliente, $comentario, $calificacion, $fecha_registro);
$queryInsertarComentario->execute();
$queryInsertarComentario->close();

header("Location: ../pages/Productos.php");
?>