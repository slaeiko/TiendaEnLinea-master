<?php
//productos_lista.php
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM productos 
        WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);
$num = $res->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de productos</title>
<link rel="stylesheet" type="text/css" href="css/styles_lista.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function() {
    $(".eliminar-producto").click(function(e) {
        e.preventDefault();
        var productoID = $(this).data('id');
        if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
            $.ajax({
                url: 'productos_elimina.php',
                type: 'post',
                data: { id: productoID },
                success: function(response) {
                    if (response == 'success') {
                        // Eliminar la fila correspondiente
                        $('#producto_' + productoID).remove();
                    } else {
                        alert('Error al eliminar el producto');
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
<div class="display-4">Listado de productos <?php //echo $num; ?></div>
<div style="text-align: right;">
    <a href="productos_alta.php" class="btn btn-outline-success btn-sm">Agregar un nuevo producto</a>
</div>
<div class="empleado">
        <div class="id">ID</div>
        <div class="nombre">Nombre</div>
        <div class="nombre">Codigo</div>
        <div class="nombre">Descripcion</div>
        <div class="nombre">Costo</div>
        <div class="nombre">Stock</div>
        <div class="accion">Eliminar</div>
        <div class="accion">Ver detalle</div>
        <div class="accion">Editar</div>
</div>
<?php
while ($row = $res->fetch_array()) {
    $id = $row["id"];
    $nombre = $row["nombre"];
    $codigo = $row["codigo"];
    $descripcion = $row["descripcion"];
    $costo = $row["costo"];
    $stock = $row["stock"];
?>
    <div class="empleado" id="producto_<?php echo $id; ?>">
        <div class="id"><?php echo $id; ?></div>
        <div class="nombre"><?php echo $nombre; ?></div>
        <div class="nombre"><?php echo $codigo; ?></div>
        <div class="nombre"><?php echo $descripcion; ?></div>
        <div class="nombre"><?php echo $costo; ?></div>
        <div class="nombre"><?php echo $stock; ?></div>

        <div class="accion"><a href="#" class=" btn btn-danger eliminar-producto" data-id="<?php echo $id; ?>">Eliminar</a></div>
        <div class="accion"><a href="productos_detalle.php?id=<?php echo $id; ?>" class="btn btn-success">Ver detalle</a></div>
        <div class="accion"><a href="productos_editar.php?id=<?php echo $id; ?>" class="btn btn-warning">Editar</a></div>
    </div>
<?php
}
?>

</div>
</body>
</html>
