<?php
// promociones_lista.php
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM promociones 
        WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);
$num = $res->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Promociones</title>
<link rel="stylesheet" type="text/css" href="css/styles_lista.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function() {
    $(".eliminar-promocion").click(function(e) {
        e.preventDefault();
        var promocionID = $(this).data('id');
        if (confirm("¿Estás seguro de que deseas eliminar esta promoción?")) {
            $.ajax({
                url: 'promociones_elimina.php',
                type: 'post',
                data: { id: promocionID },
                success: function(response) {
                    if (response == 'success') {
                        // Eliminar la fila correspondiente
                        $('#promocion_' + promocionID).remove();
                    } else {
                        alert('Error al eliminar la promoción');
                    }
                },
                error: function() {
                    alert('Error al conectar con el servidor');
                }
            });
        }
    });
});
</script>
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
<div class="separacion_menu">
<div class="display-4">Listado de Promociones <?php //echo $num; ?></div>
<div style="text-align: right;">
    <a href="promociones_alta.php" class="btn btn-outline-success btn-sm">Agregar una nueva promoción</a>
</div>
<div class="empleado">
        <div class="id">ID</div>
        <div class="nombre">Nombre</div>
        <div class="accion">Eliminar</div>
        <div class="accion">Ver detalle</div>
        <div class="accion">Editar</div>
</div>
<?php
while ($row = $res->fetch_array()) {
    $id = $row["id"];
    $nombre = $row["nombre"];
?>
    <div class="empleado" id="promocion_<?php echo $id; ?>">
        <div class="id"><?php echo $id; ?></div>
        <div class="nombre"><?php echo $nombre; ?></div>
        <div class="accion"><a href="#" class="btn btn-danger eliminar-promocion" data-id="<?php echo $id; ?>">Eliminar</a></div>
        <div class="accion"><a href="promociones_detalle.php?id=<?php echo $id; ?>" class="btn btn-success">Ver detalle</a></div>
        <div class="accion"><a href="promociones_editar.php?id=<?php echo $id; ?>" class="btn btn-warning">Editar</a></div>
    </div>
<?php
}
?>

</div>
</body>
</html>
