<?php
// productos_detalle.php

include 'menu.php'; 
// Verificar si hay una sesión iniciada
if (!isset($_SESSION['nombre'])) {
    // Si no hay una sesión iniciada, redirige al usuario a la página de inicio de sesión
    header("Location: index.php");
    exit();
}else {
    // Establecer el valor predeterminado de las variables del producto
    $nombre = '';
    $codigo = '';
    $descripcion = '';
    $costo = '';
    $stock = '';
    $status = '';
}

require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST['id'];

$sql = "SELECT * FROM productos
        WHERE eliminado = 0 AND id = $id";
$res = $con->query($sql);

if ($res->num_rows > 0) {
    // Obtener los datos del producto
    $row = $res->fetch_assoc();
    $nombre = $row['nombre'];
    $codigo = $row['codigo'];
    $descripcion = $row['descripcion'];
    $costo = $row['costo'];
    $stock = $row['stock'];
    $status = $row['status'] == 1 ? 'Activo' : 'Inactivo';
    $archivo_n = $row['archivo_n']; // Nombre original del archivo
    $archivo_file = $row['archivo']; // Nombre encriptado del archivo
    $ruta_imagen = "archivos/$archivo_file"; // Ruta de la imagen
} else {
    echo "No se encontró ningún producto con el ID proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle del producto</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="detalle-empleado">
    <h1 class="display-6" style="color: white;">Detalle del producto</h1>
    <div class="detalle-item"><a href="productos_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
    <!-- Campo oculto para el ID del producto -->
    <input type="hidden" id="idProducto" value="<?php echo $id; ?>">
    <div class="detalle-item">
        <label>Nombre:</label>
        <span><?php echo $nombre; ?></span>
    </div>
    <div class="detalle-item">
        <label>Código:</label>
        <span><?php echo $codigo; ?></span>
    </div>
    <div class="detalle-item">
        <label>Descripción:</label>
        <span><?php echo $descripcion; ?></span>
    </div>
    <div class="detalle-item">
        <label>Costo:</label>
        <span><?php echo $costo; ?></span>
    </div>
    <div class="detalle-item">
        <label>Stock:</label>
        <span><?php echo $stock; ?></span>
    </div>
    <div class="detalle-item">
        <label>Estatus:</label>
        <span><?php echo $status; ?></span>
    </div>
    <!-- Imagen del producto -->
    <div class="img">
        <img src="<?php echo $ruta_imagen; ?>" alt="Foto del producto">
    </div>
</div>
</body>
</html>
