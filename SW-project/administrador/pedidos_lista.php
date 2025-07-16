<?php
//pedidos_lista.php
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM pedidos WHERE status = 1";
$res = $con->query($sql);
$num = $res->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de Pedidos</title>
<link rel="stylesheet" type="text/css" href="css/styles_lista.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include 'menu.php'; ?>

<div class="separacion_menu">
<div class="display-4">Listado de Pedidos Cerrados <?php //echo $num; ?></div>

<div class="empleado">
        <div class="id">ID</div>
        <div class="nombre">Fecha</div>
        <div class="accion">ID Usuario</div>
        <div class="accion">Ver detalle</div>
</div>
<?php
while ($row = $res->fetch_array()) {
    $id = $row["id"];
    $fecha = $row["fecha"];
    $id_usuario = $row["id_usuario"];
?>
    <div class="empleado" id="pedido_<?php echo $id; ?>">
        <div class="id"><?php echo $id; ?></div>
        <div class="nombre"><?php echo $fecha; ?></div>
        <div class="accion"><?php echo $id_usuario; ?></div>
        <div class="accion"><a href="pedido_detalle.php?id=<?php echo $id; ?>" class="btn btn-success">Ver detalle</a></div>
    </div>
<?php
}
?>

</div>
</body>
</html>
