<?php
// autocompletar.php
require "funciones/conecta.php";
$con = conecta();

$termino = isset($_GET['term']) ? trim($_GET['term']) : '';

if ($termino !== '') {
    // Consulta para buscar productos 
    $sql = "SELECT nombre FROM productos WHERE status = 1 AND eliminado = 0 AND nombre LIKE ? LIMIT 5";
    $stmt = $con->prepare($sql);
    $termino_param = "%$termino%";
    $stmt->bind_param("s", $termino_param);
    $stmt->execute();
    $result = $stmt->get_result();

    $sugerencias = [];
    while ($row = $result->fetch_assoc()) {
        $sugerencias[] = $row['nombre'];
    }

    // Devolver los resultados como JSON
    echo json_encode($sugerencias);
}