<?php
// validar_correo.php
require "funciones/conecta.php";
$con = conecta();

if(isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    // Verificar si el correo ya existe en la base de datos
    $sql_correo_existente = "SELECT COUNT(*) AS total FROM empleados WHERE correo = '$correo'";
    $res_correo_existente = $con->query($sql_correo_existente);
    $row_correo_existente = $res_correo_existente->fetch_assoc();
    if ($row_correo_existente["total"] > 0) {
        echo "correo_existente";
        exit;
    } else {
        echo "correo_no_existente";
    }
}
?>
