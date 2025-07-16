<!--index.php-->
<?php
session_start();

// Verifica si la sesión 'nombre' está definida
if(isset($_SESSION['nombre'])) {
    // Si la sesión está definida, redirige al usuario a bienvenido.php
    header("Location: bienvenido.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function() {
    $("#loginForm").submit(function(event) {
        event.preventDefault();
        var correo = $("#correo").val();
        var contrasena = $("#pass").val();

        if (correo == '' || contrasena == '') {
            $("#mensaje").html("Faltan campos por llenar.");
            setTimeout(function() {
                $("#mensaje").html("");
            }, 5000); 
        } else {
            $.ajax({
                type: 'POST',
                url: 'validar_usuario.php',
                data: $(this).serialize(),
                success: function(response) {
                    if (response == 'correo_existente') {
                        window.location.href = 'bienvenido.php';
                    } else {
                        $("#mensaje").html("Correo o contraseña incorrecto.");
                        setTimeout(function() {
                            $("#mensaje").html("");
                        }, 5000); 
                    }
                }
            });
        }
    });
});
</script>
</head>
<body>
<div class="detalle-empleado">
<div class="titulo">Login</div>
<form id="loginForm" method="post">
    <div class="detalle-item">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo">
    </div>
    <div class="detalle-item">
        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass">
    </div>
    <button type="submit" class="btn btn-success">Enviar</button>
</form>
<div id="mensaje" style="color: red;"></div>
</div>
</body>
</html>