<?php
//pedido_detalle.php
require "funciones/conecta.php";
$con = conecta();
$id_pedido = $_REQUEST['id'];

$sql_pedido = "SELECT * FROM pedidos WHERE id = $id_pedido";
$res_pedido = $con->query($sql_pedido);

if ($res_pedido->num_rows > 0) {
    $pedido = $res_pedido->fetch_assoc();
    $fecha = $pedido['fecha'];
    $id_usuario = $pedido['id_usuario'];
} else {
    echo "No se encontró ningún pedido con el ID proporcionado.";
    exit;
}

$sql_productos = "SELECT productos.nombre, pedidos_productos.cantidad, pedidos_productos.precio 
                  FROM pedidos_productos
                  JOIN productos ON pedidos_productos.id_producto = productos.id
                  WHERE pedidos_productos.id_pedido = $id_pedido";
$res_productos = $con->query($sql_productos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle de Pedido</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include 'menu.php'; ?>
<div class="detalle-empleado">
    <h1 class="titulo">Detalle de Pedido</h1>
    <div class="detalle-item"><a href="pedidos_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
    <div class="detalle-item">
        <label>ID Pedido:</label>
        <span><?php echo $id_pedido; ?></span>
    </div>
    <div class="detalle-item">
        <label>Fecha:</label>
        <span><?php echo $fecha; ?></span>
    </div>
    <div class="detalle-item">
        <label>ID Usuario:</label>
        <span><?php echo $id_usuario; ?></span>
    </div>
    
    <div class="detalle-item">
    <h2>Productos del Pedido</h2>
    <table>
        <thead style="text-align: left;">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $gran_total = 0;
            while ($row = $res_productos->fetch_assoc()) {
                $nombre = $row['nombre'];
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $subtotal = $cantidad * $precio;
                $gran_total += $subtotal;
                echo "<tr>
                        <td>$nombre</td>
                        <td>$cantidad</td>
                        <td>$precio</td>
                        <td>$subtotal</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    <div class="detalle-item">
        <label>Gran Total:</label>
        <span><?php echo $gran_total; ?></span>
    </div>
</div>
</body>
</html>
