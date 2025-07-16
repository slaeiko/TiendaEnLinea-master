<?php
// validar_codigo.php
require "funciones/conecta.php";
$con = conecta();

if(isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];

    // Verificar si el código ya existe en la base de datos
    $sql_codigo_existente = "SELECT COUNT(*) AS total FROM productos WHERE codigo = '$codigo'";
    $res_codigo_existente = $con->query($sql_codigo_existente);
    $row_codigo_existente = $res_codigo_existente->fetch_assoc();
    if ($row_codigo_existente["total"] > 0) {
        echo "codigo_existente";
        exit;
    } else {
        echo "codigo_no_existente";
    }
}
?>
