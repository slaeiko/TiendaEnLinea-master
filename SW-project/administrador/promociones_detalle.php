<?php
// productos_detalle.php

include 'menu.php'; 
// Verificar si hay una sesión iniciada
if (!isset($_SESSION['nombre'])) {
    // Si no hay una sesión iniciada, redirige al usuario a la página de inicio de sesión
    header("Location: index.php");
    exit();
}else {
    // Establecer el valor predeterminado de las variables de la promocion
    $nombre = '';
    $status = '';
}

require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST['id'];

$sql = "SELECT * FROM promociones
        WHERE eliminado = 0 AND id = $id";
$res = $con->query($sql);

if ($res->num_rows > 0) {
    // Obtener los datos de la promocion
    $row = $res->fetch_assoc();
    $nombre = $row['nombre'];
    $status = $row['status'] == 1 ? 'Activo' : 'Inactivo';
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
<title>Detalle de promoción</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="detalle-empleado">
    <h1 class="display-6" style="color: white;">Detalle de promoción</h1>
    <div class="detalle-item"><a href="promociones_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
    <!-- Campo oculto para el ID de la promocion -->
    <input type="hidden" id="idProducto" value="<?php echo $id; ?>">
    <div class="detalle-item">
        <label>Nombre:</label>
        <span><?php echo $nombre; ?></span>
    </div>
    <div class="detalle-item">
        <label>Estatus:</label>
        <span><?php echo $status; ?></span>
    </div>
    <!-- Imagen de la promocion -->
    <div class="promo">
        <img src="<?php echo $ruta_imagen; ?>" alt="Foto de la promoción">
    </div>
</div>
</body>
</html>
