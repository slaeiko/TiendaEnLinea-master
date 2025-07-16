<?php
// producto_detalle.php
session_start();
require "funciones/conecta.php";
$con = conecta();

$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id = $id AND status = 1 AND eliminado = 0";
$res = $con->query($sql);

if ($res->num_rows > 0) {
    $producto = $res->fetch_assoc();
} else {
    echo "Producto no encontrado";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section id="detalle-producto">
        <div class="producto-detalle">
            <img src="administrador/archivos/<?php echo $producto['archivo']; ?>" alt="<?php echo $producto['nombre']; ?>">
            <h2><?php echo $producto['nombre']; ?></h2>
            <p>Código: <?php echo $producto['codigo']; ?></p>
            <p><?php echo $producto['descripcion']; ?></p>
            <p>Costo: $<?php echo $producto['costo']; ?></p>
            <form action="carrito_agregar.php" method="post">
                <input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" value="1" min="1" required>
                <button type="submit">Agregar al Carrito</button>
            </form>
        </div>
    </section>
    
    <?php include 'footer.php'; ?>
</body>
</html>
