<?php
// session_start();
if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) or empty($_POST["password"])) {
        echo "<div>POR FAVOR LLENAR LOS CAMPOS</div>";
    } else {
        $usuario = $_POST["usuario"];
        $clave = $_POST["password"];

        // Llamada al procedimiento almacenado
        $sql = "CALL sp_Validar_1(?, ?, @contador);";
        $stmt = $conexion->prepare($sql);

        // Asociar parámetros
        $stmt->bind_param("ss", $usuario, $clave);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el valor del contador
            $result = $conexion->query("SELECT @contador as contador");

            if ($result) {
                $row = $result->fetch_assoc();
                $contador = isset($row['contador']) ? $row['contador'] : 0;

                // Liberar el resultado
                $result->free();

                // Verificar el valor del contador
                if ($contador > 0) {
                    echo '<div>Acceso Permitido</div>';
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['clave'] = $clave;
                    header("location: plataforma.php");
                    exit();
                } else {
                    echo '<div>Acceso Denegado</div>';
                }
            } else {
                echo "Error en la consulta SELECT: " . $conexion->error;
            }
        } else {
            echo "Error en la llamada al procedimiento almacenado: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    }
}

$conexion->close();
?>




