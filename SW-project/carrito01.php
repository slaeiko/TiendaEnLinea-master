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
    <title>Carrito de Compras</title>
</head>
<body>
<?php include 'header.php'; ?>

<?php
// Mostrar el mensaje de agradecimiento si existe la variable de sesión
if (isset($_SESSION['compra_exitosa'])) {
    echo "<p style='text-align: center; color: green;'>Gracias por su compra</p>";
    // Eliminar la variable de sesión después de mostrar el mensaje
    unset($_SESSION['compra_exitosa']);
}
?>

<h2 style="text-align: center;">Carrito de Compras</h2>
<form method="POST" action="carrito_actualizar.php">
    <table>
        <thead style="text-align: left;">
            <tr>
                <th>Producto</th>
                <th>Precio por producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
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
                        <td><input type='number' name='cantidad[{$producto['id']}]' value='{$producto['cantidad']}' min='1'></td>
                        <td>$producto_subtotal</td>
                        <td><button type='submit' name='remove' value='{$producto['id']}'>Eliminar</button></td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <div>
        <h3>Total: <?php echo $subtotal; ?></h3>
        <button type="submit" name="update">Actualizar Carrito</button>
        <a href="carrito02.php">Proceder al Pago</a>
    </div>
</form>
<?php include 'footer.php'; ?>
</body>
</html>
