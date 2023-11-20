<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Datos Guardados</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Imagen</th>
        </tr>
        <?php 
        require('conexion.bd.php');
        $query = mysqli_query($conexion, "SELECT * FROM `User`");
        $result = mysqli_num_rows($query);
        if ($result > 0){
            while ($data = mysqli_fetch_array($query)){
            ?>
                <tr>
                    <td><?php echo $data['id'] ?></td>
                    <td><?php echo $data['nombres'] ?></td>
                    <td><?php echo $data['apellidos'] ?></td>
                    <td><img height='50px' src="data:image/jpg;base64, <?php echo base64_encode($data['imagen']) ?>" alt=""></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <button>
        <a href="agregarEmpleados.php">Regresar</a>
    </button>
</body>
</html>