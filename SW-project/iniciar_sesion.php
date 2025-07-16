<?php
// iniciar_sesion.php
session_start();
require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM clientes WHERE correo = '$correo' AND pass = '$pass'";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        $cliente = $res->fetch_assoc();
        $_SESSION['id_cliente'] = $cliente['id'];
        $_SESSION['nombre'] = $cliente['nombre'];
        $_SESSION['apellido'] = $cliente['apellido'];
        $_SESSION['archivo'] = $cliente['archivo'];

        if (isset($_SESSION['redirect_after_login'])) {
            $redirect_url = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect_url");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="body2">
<div class="container">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="iniciar_sesion.php" method="post">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
