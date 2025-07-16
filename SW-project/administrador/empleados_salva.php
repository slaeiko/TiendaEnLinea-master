<?php
//empleados_salva.php
    require "funciones/conecta.php";
    $con = conecta();

    $nombre = $_REQUEST['nombre'];
    $apellidos = $_REQUEST['apellidos'];
    $correo = $_REQUEST['correo'];
    $contrasena = $_REQUEST['pass'];
    $rol = $_REQUEST['rol'];
    $archivo_n = $_FILES['foto']['name'];
    $archivo_temp = $_FILES['foto']['tmp_name'];
    $ext = pathinfo($archivo_n, PATHINFO_EXTENSION);
    $archivo = md5_file($archivo_temp);
    $file_Name1 = "$archivo.ext";
    $dir = "archivos/$file_Name1";

    if (move_uploaded_file($archivo_temp, $dir)) {
        $archivo_n;
        $file_Name1;
    } else {
        echo "Error al subir la foto.";
        exit();
    }

     // Encriptar la contraseña
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT); 


    $sql = "INSERT INTO empleados
    (nombre, apellidos, correo, pass, rol, archivo_nombre, archivo_file)
    VALUES ('$nombre', '$apellidos', '$correo', '$contrasena_encriptada', $rol, '$archivo_n', '$file_Name1')";
    $res = $con->query($sql);

    header("Location: empleados_lista.php");
?>