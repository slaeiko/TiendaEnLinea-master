<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_cliente'])) {
    header("Location: iniciar_sesion.php");
    exit;
}

$id_cliente = $_SESSION['id_cliente'];

// Obtener el pedido abierto del usuario
$sql = "SELECT id FROM pedidos WHERE id_usuario = $id_cliente AND status = 0";
$res = $con->query($sql);
if ($res->num_rows > 0) {
    $pedido = $res->fetch_assoc();
    $id_pedido = $pedido['id'];
    
    // Obtener los productos del pedido
    $sql = "SELECT productos.id, productos.nombre, productos.costo, pedidos_productos.cantidad
            FROM pedidos_productos
            JOIN productos ON pedidos_productos.id_producto = productos.id
            WHERE pedidos_productos.id_pedido = $id_pedido";
    $res = $con->query($sql);

    $productos = [];
    while ($row = $res->fetch_assoc()) {
        $productos[] = $row;
    }
} else {
    $productos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pedido</title>
</head>
<body>
<?php include 'header.php'; ?>
    <h2 style="text-align: center;">Confirmar Pedido</h2>
    <form method="POST" action="pedido_confirmar.php">
        <table>
            <thead style="text-align: left;">
                <tr>
                    <th>Producto</th>
                    <th>Precio por producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                foreach ($productos as $producto) {
                    $producto_subtotal = $producto['costo'] * $producto['cantidad'];
                    $subtotal += $producto_subtotal;
                    echo "<tr>
                            <td>{$producto['nombre']}</td>
                            <td>{$producto['costo']}</td>
                            <td>{$producto['cantidad']}</td>
                            <td>$producto_subtotal</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <div>
            <h3>Total: <?php echo $subtotal; ?></h3>
            <button type="submit" name="confirm">Confirmar Pedido</button>
        </div>
    </form>
<?php include 'footer.php'; ?>
</body>
</html>
