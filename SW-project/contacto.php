<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $texto = filter_var($_POST['texto'], FILTER_SANITIZE_STRING);

    if (!empty($email) && !empty($nombre) && !empty($texto)) {
        $destino = 'iharamy.verde8645@alumnos.udg.mx';
        $asunto = 'QuickMarket';
        $cuerpo = '<html>
<head>
<title>Prueba de correo</title>
</head>
<body>
<h1>Email de: ' . $nombre . '</h1>
<p>' . $texto . '</p>
</body>
</html>';

        // Para el envío en formato HTML
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        // Dirección del remitente
        $headers .= "From: $nombre <$email>\r\n";
        // Ruta del mensaje desde origen a destino
        $headers .= "Return-path: $destino\r\n";

        if (mail($destino, $asunto, $cuerpo, $headers)) {
            $mensaje = "Email enviado correctamente";
        } else {
            $mensaje = "Error al enviar el email";
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="body2">
    <div class="container">
    <h2 style="text-align: center;">Contacto</h2>
        <?php if (isset($mensaje)): ?>
            <div class="message"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form action="contacto.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="texto">Mensaje:</label>
            <textarea id="texto" name="texto" rows="4" required></textarea>
            
            <button type="submit">Enviar</button>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
