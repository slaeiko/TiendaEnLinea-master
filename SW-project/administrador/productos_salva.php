<?php
    // productos_salva.php
    require "funciones/conecta.php";
    $con = conecta();

    $nombre = $_REQUEST['nombre'];
    $codigo = $_REQUEST['codigo'];
    $descripcion = $_REQUEST['descripcion'];
    $costo = $_REQUEST['costo'];
    $stock = $_REQUEST['stock'];
    $archivo_n = $_FILES['foto']['name'];
    $archivo_temp = $_FILES['foto']['tmp_name'];
    $ext = pathinfo($archivo_n, PATHINFO_EXTENSION);
    $archivo = md5_file($archivo_temp);
    $file_Name1 = "$archivo.ext";
    $dir = "archivos/$file_Name1";

    if (move_uploaded_file($archivo_temp, $dir)) {
        $archivo_n;
        $file_Name1;
    } else {
        echo "Error al subir la foto.";
        exit();
    }

    $sql = "INSERT INTO productos
        (nombre, codigo, descripcion, costo, stock, archivo_n, archivo)
        VALUES ('$nombre', '$codigo', '$descripcion', $costo, $stock, '$archivo_n', '$file_Name1')";
    $res = $con->query($sql);

    header("Location: productos_lista.php");
?>
