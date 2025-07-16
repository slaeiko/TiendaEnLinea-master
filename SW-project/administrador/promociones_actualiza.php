<?php
// promociones_actualizar.php
require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $porcentaje = $_POST["porcentaje"];

    // Verificar si se proporcionó un archivo
    if (!empty($_FILES['foto']['name'])) {
        $archivo_n = $_FILES['foto']['name'];
        $archivo_temp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($archivo_n, PATHINFO_EXTENSION);
        $archivo = md5_file($archivo_temp) . ".$ext";
        $dir = "archivos/$archivo";

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($archivo_temp, $dir)) {
            // Actualizar el nombre del archivo en la base de datos
            $sql = "UPDATE promociones SET nombre = '$nombre', porcentaje = '$porcentaje', archivo = '$archivo' WHERE id = $id"; 
        } else {
            echo "Error al subir la foto.";
            exit();
        }
    } else {
        // Si no se proporciona una nueva imagen, actualizar solo otros campos
        $sql = "UPDATE promociones SET nombre = '$nombre', porcentaje = '$porcentaje' WHERE id = $id";
    }

    // Actualizar promoción en la base de datos
    if ($con->query($sql) === TRUE) {
        header("Location: promociones_lista.php");
        exit();
    } else {
        echo "Error al actualizar la promoción.";
    }
} else {
    echo "Error: Método de solicitud no válido.";
}
?>
