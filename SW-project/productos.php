<?php
//productos.php
// Conectar a la base de datos
require "funciones/conecta.php";
$con = conecta();

// Para obtener el termino de busqueda si existe
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Crear la consulta SQL
if ($busqueda) {
    // Si hay una busqueda, filtra los productos
    $sql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0 AND nombre LIKE ?";
    $stmt = $con->prepare($sql);
    $busqueda_param = "%$busqueda%";
    $stmt->bind_param("s", $busqueda_param);
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    // Si no hay busqueda, mostrar todos los productos
    $sql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0";
    $res = $con->query($sql);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" type="text/css" href="diseños.css">
    <title>Productos</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <section id="producto">
        <h2>Productos</h2>
        <?php
        // Mostrar mensaje si no se encuentran productos
        if ($res->num_rows === 0) {
            echo "<p>No se encontraron productos que coincidan con la búsqueda.</p>";
        } else {
            // Contador para crear filas
            $contador = 0;

            echo '<div class="fila">';
            while ($row = $res->fetch_assoc()) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $archivo = $row['archivo'];
                $descripcion = $row['descripcion'];

                echo '<div class="item">';
                echo "<a href='producto_detalle.php?id=$id'>";
                echo "<img src='administrador/archivos/$archivo' alt='$nombre'>";
                echo "<p>$nombre</p>";
                echo "<p>$descripcion</p>";
                echo "</a>";
                echo '</div>';

                $contador++;
                if ($contador % 3 == 0) {
                    echo '</div><div class="fila">'; // Crear una nueva fila después de 3 productos
                }
            }
            echo '</div>';
        }
        ?>
    </section>
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>