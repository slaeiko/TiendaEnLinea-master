<?php
// promociones_editar.php

include 'menu.php'; 
// Verificar si hay una sesión iniciada
if (!isset($_SESSION['nombre'])) {
    // Si no hay una sesión iniciada, redirige al usuario a la página de inicio de sesión
    header("Location: index.php");
    exit();
} else {
    // Establecer el valor predeterminado de las variables del producto
    $nombre = '';
    $porcentaje = 0.00;
}

require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Obtener datos de la promocion para precargar el formulario
    $sql = "SELECT * FROM promociones WHERE eliminado = 0 AND id = $id";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombre = $row["nombre"];
        $porcentaje = $row["porcentaje"];
    } else {
        echo "No se encontró ningún producto con el ID proporcionado.";
        exit;
    }
} else {
    echo "Error: No se proporcionó un ID de producto válido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edición de promoción</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});

function valida() {
    var nombre = document.forma01.nombre.value;
    var porcentaje = document.forma01.porcentaje.value;

    if (nombre === "" || porcentaje === "") {
        $('#mensaje').html('Faltan campos por llenar').css("color", "red");
        setTimeout(function() { $('#mensaje').html(''); }, 5000);
        return false;
    } else {
        return true;
    }
}
</script>
</head>
<body>
<div class="detalle-empleado">
    <h1 class="display-6" style="color: white;">Edición de promoción</h1>
    <div class="detalle-item"><a href="promociones_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado</a></div>
    <form enctype="multipart/form-data" name="forma01" action="promociones_actualiza.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="detalle-item">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
        </div>
        <div class="detalle-item">
            <label for="porcentaje">Porcentaje:</label>
            <input type="text" id="porcentaje" name="porcentaje" value="<?php echo $porcentaje; ?>">
        </div>
        <div class="detalle-item">
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <div>Seleccione una nueva imagen si desea cambiarla.</div>
        </div>
        <button type="submit" onclick="return valida();" class="btn btn-success">Guardar</button>
    </form>
    <div id='mensaje'></div>
</div>
</body>
</html>

