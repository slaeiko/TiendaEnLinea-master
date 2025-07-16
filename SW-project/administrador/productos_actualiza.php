<?php
// productos_actualizar.php
require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $costo = $_POST["costo"];
    $stock = $_POST["stock"];

    // Procesar la carga de la imagen si se proporciona
    if (!empty($_FILES['foto']['name'])) {
        $archivo_n = $_FILES['foto']['name'];
        $archivo_temp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($archivo_n, PATHINFO_EXTENSION);
        $archivo = md5_file($archivo_temp);
        $file_Name1 = "$archivo.$ext";
        $dir = "archivos/$file_Name1";

        if (move_uploaded_file($archivo_temp, $dir)) {
            // Si se carga la imagen correctamente, actualiza el nombre del archivo en la base de datos
            $sql = "UPDATE productos SET nombre = '$nombre', codigo = '$codigo', descripcion = '$descripcion', costo = $costo, stock = $stock, archivo_n = '$archivo_n', archivo = '$file_Name1' WHERE id = $id"; 
        } else {
            echo "Error al subir la foto.";
            exit();
        }
    } else {
        // Si no se proporciona una nueva imagen, actualiza solo los otros campos
        $sql = "UPDATE productos SET nombre = '$nombre', codigo = '$codigo', descripcion = '$descripcion', costo = $costo, stock = $stock WHERE id = $id";
    }

    // Actualizar producto en la base de datos
    if ($con->query($sql) === TRUE) {
        header("Location: productos_lista.php");
        exit();
    } else {
        echo "Error al actualizar el producto.";
    }
} else {
    echo "Error: Método de solicitud no válido.";
}
?>
