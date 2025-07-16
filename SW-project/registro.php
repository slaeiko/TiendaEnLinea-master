<?php
// registro.php
session_start();
require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $apellido = filter_var($_POST['apellido'], FILTER_SANITIZE_STRING);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    // Manejar la subida del archivo
    $archivo = $_FILES['archivo'];
    $archivo_nombre = $archivo['name'];
    $archivo_tmp = $archivo['tmp_name'];
    $archivo_destino = "./" . $archivo_nombre;
    move_uploaded_file($archivo_tmp, $archivo_destino);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO clientes (nombre, apellido, correo, pass, archivo) VALUES ('$nombre', '$apellido', '$correo', '$pass', '$archivo_destino')";
    if ($con->query($sql)) {
        $_SESSION['id_cliente'] = $con->insert_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['archivo'] = $archivo_destino;
        header("Location: index.php");
        exit;
    } else {
        $error = "Error al registrar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="body2">
<div class="container">
    <h2>Registro</h2>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="registro.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="archivo">Foto de perfil:</label>
        <input type="file" id="archivo" name="archivo" required>
        <br>
        <button type="submit">Registrarse</button>
    </form>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
