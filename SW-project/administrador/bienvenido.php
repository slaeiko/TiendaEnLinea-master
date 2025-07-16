<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
        .imagen_fondo {
            background-image: url('logo.png'); 
            background-size: cover; /* Asegura que la imagen cubra todo el div */
            background-position: center; /* Centra la imagen */
            color: white; /* Asegura que el texto siga siendo blanco */
            padding: 260px; /* Añade padding para que el div tenga algo de espacio alrededor */
            display: flex;
            justify-content: center;
            align-items: flex-end; /* Mueve el contenido hacia abajo */
            height: 100vh; /* Asegura que el div cubra toda la altura de la pantalla */
        }

        .imagen_fondo p {
            position: absolute;
            bottom: 20px; 
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            padding: 10px;
            border-radius: 5px;
        }
</style>
<div class="detalle-empleado">
</head>
<body>
<?php 
    include 'menu.php'; 

    if (!isset($_SESSION['nombre'])) {
        // Si no está definida, redirige al usuario a la página de inicio de sesión
        header("Location: index.php");
        exit();
    }
?>
</div>

<div class="imagen_fondo">
        <!--<div class="display-4">Tablero de inicio</div>-->
        <p class="display-6">Hola <?=$nombreCompleto;?> bienvenid@ al Sistema de Administración.</p>
    </div>
</body>
</html>