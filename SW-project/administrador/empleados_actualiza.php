<?php
// empleados_actualizar.php
require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];
    $contrasena = $_POST["pass"];

    // Si se proporciona una nueva contraseña, encriptarla
    if (!empty($contrasena)) {
        $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE empleados SET nombre = '$nombre', apellidos = '$apellidos', correo = '$correo', rol = $rol, pass = '$contrasena_encriptada' WHERE id = $id"; 
    } else {
        // Si no se proporciona una nueva contraseña, mantener la misma
        $sql = "UPDATE empleados SET nombre = '$nombre', apellidos = '$apellidos', correo = '$correo', rol = $rol WHERE id = $id";
    }

    // Procesar la carga de la imagen si se proporciona
    if (!empty($_FILES['foto']['name'])) {
        $archivo_n = $_FILES['foto']['name'];
        $archivo_temp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($archivo_n, PATHINFO_EXTENSION);
        $archivo = md5_file($archivo_temp);
        $file_Name1 = "$archivo.$ext";
        $dir = "archivos/$file_Name1";

        if (move_uploaded_file($archivo_temp, $dir)) {
            // Si se carga la imagen correctamente, actualiza el nombre del archivo en la base de datos
            $sql = "UPDATE empleados SET nombre = '$nombre', apellidos = '$apellidos', correo = '$correo', rol = $rol, archivo_nombre = '$archivo_n', archivo_file = '$file_Name1' WHERE id = $id"; 
        } else {
            echo "Error al subir la foto.";
            exit();
        }
    } else {
        // Si no se proporciona una nueva imagen, actualiza solo los otros campos
        $sql = "UPDATE empleados SET nombre = '$nombre', apellidos = '$apellidos', correo = '$correo', rol = $rol WHERE id = $id";
    }


    // Actualizar empleado en la base de datos
    if ($con->query($sql) === TRUE) {
        header("Location: empleados_lista.php");
        exit();
    } else {
        echo "error";
    }
} else {
    echo "Error: Método de solicitud no válido.";
}
?>
