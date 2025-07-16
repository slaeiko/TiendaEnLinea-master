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

    // Cambiar el estado del pedido a cerrado
    $sql = "UPDATE pedidos SET status = 1 WHERE id = $id_pedido";
    $con->query($sql);
}

// Establecer una variable de sesión para el mensaje de agradecimiento
$_SESSION['compra_exitosa'] = true;

header("Location: carrito01.php");
exit;
?>

