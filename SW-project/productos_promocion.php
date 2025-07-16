<?php
require "funciones/conecta.php";
$con = conecta();

if (isset($_GET["idPromocion"])) {
    $idPromocion = $_GET["idPromocion"];
    echo "ID de Promoción: $idPromocion\n";

    // Obtener porcentaje de la promoción
    $sqlPromocion = "SELECT porcentaje FROM promociones WHERE id = $idPromocion";
    $resPromocion = $con->query($sqlPromocion);
    if ($resPromocion->num_rows > 0) {
        $rowPromocion = $resPromocion->fetch_assoc();
        $porcentaje = $rowPromocion["porcentaje"];
        echo "Porcentaje: $porcentaje\n";

        // Obtener 3 productos aleatorios
        $sqlProductos = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0 ORDER BY RAND() LIMIT 3";
        $resProductos = $con->query($sqlProductos);

        while ($rowProductos = $resProductos->fetch_assoc()) {
            $nombre = $rowProductos["nombre"];
            $descripcion = $rowProductos["descripcion"];
            $costoOriginal = $rowProductos["costo"];
            $costoDescuento = $costoOriginal - ($costoOriginal * $porcentaje / 100);
            $archivo = $rowProductos["archivo"];

            echo "<div class='producto'>";
            echo "<img src='administrador/archivos/$archivo' alt='$nombre'>";
            echo "<h3>$nombre</h3>";
            echo "<p>$descripcion</p>";
            echo "<p>Precio: <del>$$costoOriginal</del> $$costoDescuento</p>";
            echo "</div>";
        }
    } else {
        echo "No se encontró la promoción.";
    }
} else {
    echo "Error: No se proporcionó un ID de promoción válido.";
}
?>
