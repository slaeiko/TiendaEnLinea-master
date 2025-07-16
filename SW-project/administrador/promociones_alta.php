<!--promociones_alta.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alta de promociones</title>
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
    var foto = document.forma01.foto.value;

    if (nombre === "" ||  foto === "") {
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
<?php 
include 'menu.php'; 

if (!isset($_SESSION['nombre'])) {
    // Si no está definida, redirige al usuario a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Detiene la ejecución del script después de redirigir
}
?>
<div class="detalle-empleado">
<div class="display-6" style="color: white;">Alta de promociones</div>
<div class="detalle-item"><a href="promociones_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
<form name="forma01" method="post" enctype="multipart/form-data" action="promociones_salva.php">
    <div class="detalle-item">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre">
    </div>
    <div class="detalle-item">
        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>
    </div>
    <button type="submit" onclick="return valida();" class="btn btn-success">Guardar</button>
</form>
<div id='mensaje'></div>
</div>
</body>
</html>
