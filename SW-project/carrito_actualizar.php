<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

$id_cliente = $_SESSION['id_cliente'];

// Obtener el pedido abierto del usuario
$sql = "SELECT id FROM pedidos WHERE id_usuario = $id_cliente AND status = 0";
$res = $con->query($sql);
if ($res->num_rows > 0) {
    $pedido = $res->fetch_assoc();
    $id_pedido = $pedido['id'];
}

// Procesar las acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['cantidad'] as $id_producto => $cantidad) {
            if ($cantidad > 0) {
                $sql = "UPDATE pedidos_productos SET cantidad = $cantidad WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
            } else {
                $sql = "DELETE FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
            }
            $con->query($sql);
        }
    } elseif (isset($_POST['remove'])) {
        $id_producto = $_POST['remove'];
        $sql = "DELETE FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
        $con->query($sql);
    }
}

header("Location: carrito01.php");
exit;
?>
