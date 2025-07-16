<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_SESSION['id_cliente'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    if (!isset($id_cliente)) {
        $_SESSION['redirect_after_login'] = "carrito_agregar.php?id_producto=$id_producto&cantidad=$cantidad";
        header("Location: iniciar_sesion.php");
        exit;
    }

    // Verificar si hay un pedido abierto para el usuario
    $sql = "SELECT id FROM pedidos WHERE id_usuario = $id_cliente AND status = 0";
    $res = $con->query($sql);
    if ($res->num_rows > 0) {
        $pedido = $res->fetch_assoc();
        $id_pedido = $pedido['id'];
    } else {
        // Crear un nuevo pedido
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO pedidos (fecha, id_usuario, status) VALUES ('$fecha', $id_cliente, 0)";
        $con->query($sql);
        $id_pedido = $con->insert_id;
    }

    // Verificar si el producto ya está en el pedido
    $sql = "SELECT id, cantidad FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
    $res = $con->query($sql);
    if ($res->num_rows > 0) {
        $producto_pedido = $res->fetch_assoc();
        $nueva_cantidad = $producto_pedido['cantidad'] + $cantidad;
        $sql = "UPDATE pedidos_productos SET cantidad = $nueva_cantidad WHERE id = {$producto_pedido['id']}";
    } else {
        // Obtener el precio del producto
        $sql = "SELECT costo FROM productos WHERE id = $id_producto";
        $res = $con->query($sql);
        $producto = $res->fetch_assoc();
        $precio = $producto['costo'];

        // Agregar el producto al pedido
        $sql = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $id_producto, $cantidad, $precio)";
    }
    $con->query($sql);

    header("Location: carrito01.php");
    exit;
}

// Redirigir al detalle del producto si se llega a este punto por GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_producto']) && isset($_GET['cantidad'])) {
    $id_producto = $_GET['id_producto'];
    $cantidad = $_GET['cantidad'];

    if (!isset($_SESSION['id_cliente'])) {
        $_SESSION['redirect_after_login'] = "carrito_agregar.php?id_producto=$id_producto&cantidad=$cantidad";
        header("Location: iniciar_sesion.php");
        exit;
    }

    // Verificar si hay un pedido abierto para el usuario
    $id_cliente = $_SESSION['id_cliente'];
    $sql = "SELECT id FROM pedidos WHERE id_usuario = $id_cliente AND status = 0";
    $res = $con->query($sql);
    if ($res->num_rows > 0) {
        $pedido = $res->fetch_assoc();
        $id_pedido = $pedido['id'];
    } else {
        // Crear un nuevo pedido
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO pedidos (fecha, id_usuario, status) VALUES ('$fecha', $id_cliente, 0)";
        $con->query($sql);
        $id_pedido = $con->insert_id;
    }

    // Verificar si el producto ya está en el pedido
    $sql = "SELECT id, cantidad FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
    $res = $con->query($sql);
    if ($res->num_rows > 0) {
        $producto_pedido = $res->fetch_assoc();
        $nueva_cantidad = $producto_pedido['cantidad'] + $cantidad;
        $sql = "UPDATE pedidos_productos SET cantidad = $nueva_cantidad WHERE id = {$producto_pedido['id']}";
    } else {
        // Obtener el precio del producto
        $sql = "SELECT costo FROM productos WHERE id = $id_producto";
        $res = $con->query($sql);
        $producto = $res->fetch_assoc();
        $precio = $producto['costo'];

        // Agregar el producto al pedido
        $sql = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $id_producto, $cantidad, $precio)";
    }
    $con->query($sql);

    header("Location: carrito01.php");
    exit;
}
?>
