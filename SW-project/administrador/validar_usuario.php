<?php
// validar_usuario.php
session_start(); // Iniciar la sesión
require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["pass"]; 

    // Consulta SQL para verificar si el usuario existe con el correo electrónico y la contraseña proporcionados
    $sql = "SELECT * FROM empleados WHERE correo = '$correo' AND pass = '$contrasena' AND status = 1 AND eliminado = 0";
    $res = $con->query($sql);
    $num = $res->num_rows;

    if ($num > 0) {
        $row = $res->fetch_assoc();
        $_SESSION['nombre'] = $row['nombre']; // Asignar el nombre del usuario

        echo 'correo_existente'; // El usuario existe
    } else {
        echo 0; // El usuario no existe o la contraseña es incorrecta
    }
}
?>