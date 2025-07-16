<?php
// empleado_detalle.php

include 'menu.php'; 
// Verificar si hay una sesión iniciada
    if (!isset($_SESSION['nombre'])) {
        // Si no hay una sesión iniciada, redirige al usuario a la página de inicio de sesión
        header("Location: index.php");
        exit();
    }else{
        // Establecer el valor predeterminado de las variables de empleado
        $nombre = '';
        $apellidos = '';
        $correo = '';
        $rol = '';
        $contrasena = '';
    }

require "funciones/conecta.php";
$con = conecta();
$id = $_REQUEST['id'];

$sql = "SELECT * FROM empleados
        WHERE eliminado = 0 AND id = $id";
$res = $con->query($sql);

// Función para obtener el rol
function obtenerRol($rolId) {
    switch ($rolId) {
        case 1:
            return 'Gerente';
        case 2:
            return 'Coordinador';
        case 3:
            return 'Especialista';
        case 4:
            return 'Recursos Humanos';
        case 5:
            return 'Ventas';
        default:
            return 'Desconocido';
    }
}

if ($res->num_rows > 0) {
    // Obtener los datos del empleado
    $row = $res->fetch_assoc();
    $nombreCompleto = $row['nombre'] . ' ' . $row['apellidos'];
    $correo = $row['correo'];
    $rol = obtenerRol($row['rol']);
    $status = $row['status'] == 1 ? 'Activo' : 'Inactivo';
} else {
    echo "No se encontró ningún empleado con el ID proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle empleado</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="detalle-empleado">
    <h1 class="display-6" style="color: white;">Detalle del empleado</h1>
    <div class="detalle-item"><a href="empleados_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
    <!-- Campo oculto para el ID del empleado -->
    <input type="hidden" id="idEmpleado" value="<?php echo $id; ?>">
    <div class="detalle-item">
        <label>Nombre:</label>
        <span><?php echo $nombreCompleto; ?></span>
    </div>
    <div class="detalle-item">
        <label>Correo:</label>
        <span><?php echo $correo; ?></span>
    </div>
    <div class="detalle-item">
        <label>Rol:</label>
        <span><?php echo $rol; ?></span>
    </div>
    <div class="detalle-item">
        <label>Estatus:</label>
        <span><?php echo $status; ?></span>
    </div>


     <!-- Imagen de perfil -->
     <div class="img">
        <?php
        $archivo_nombre = $row['archivo_nombre']; // Obtener el nombre original del archivo de la base de datos
        $archivo_file = $row['archivo_file']; // Obtener el nombre encriptado del archivo de la base de datos
        $ruta_imagen = "archivos/$archivo_file"; // Construir la ruta de la imagen usando el nombre encriptado
        ?>
        <img src="<?php echo $ruta_imagen; ?>" alt="Foto de perfil">
    </div>


</div>
</body>
</html>