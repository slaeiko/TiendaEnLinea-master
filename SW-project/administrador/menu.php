<?php
//menu.php
session_start();
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '';
$apellidos = isset($_SESSION['apellidos']) ? $_SESSION['apellidos'] : '';

// Concatenar el nombre y los apellidos
$nombreCompleto = $nombre . ' ' . $apellidos;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bienvenido</title>
<link rel="stylesheet" type="text/css" href="css/menu.css">
</head>
<body>

<div class="menu">
    <div class="menu-item" style="width:600px; text-align:left;">Bienvenido <?=$nombreCompleto;?></div>
    <div class="menu-item"><a href="bienvenido.php" class="btn btn-light">Inicio</a></div>
    <div class="menu-item"><a href="empleados_lista.php" class="btn btn-light">Empleados</a></div>
    <div class="menu-item"><a href="productos_lista.php" class="btn btn-light">Productos</a></div>
    <div class="menu-item"><a href="promociones_lista.php" class="btn btn-light">Promociones</a></div> 
    <div class="menu-item"><a href="pedidos_lista.php" class="btn btn-light">Pedidos</a></div> 
    <div class="menu-item"><a href="cerrar_sesion.php" class="btn btn-light">Salir</a></div>
</div>

</body>
</html>
