<?php
// empleados_editar.php

include 'menu.php'; 
    // Verificar si hay una sesión iniciada
    if (!isset($_SESSION['nombre'])) {
        // Si no hay una sesión iniciada, redirige al usuario a la página de inicio de sesión
        header("Location: index.php");
        exit();
    }else{
        // Establecer el valor predeterminado de las variables de empleado
        $nombre = '';
        $apellidos = '';
        $correo = '';
        $rol = '';
        $contrasena = '';
    }

require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Obtener datos del empleado para precargar el formulario
    $sql = "SELECT * FROM empleados WHERE eliminado = 0 AND id = $id";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombre = $row["nombre"];
        $apellidos = $row["apellidos"];
        $correo = $row["correo"];
        $rol = $row["rol"];
        $contrasena = $row["pass"]; 
    } else {
        echo "No se encontró ningún empleado con el ID proporcionado.";
        exit;
    }
} else {
    echo "Error: No se proporcionó un ID de empleado válido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edición de empleado</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="js/jquery-3.3.1.min.js"></script>
<script>
 $(document).ready(function() {
        $("form").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
        });
    });
function valida() {
      var nombre = document.forma01.nombre.value;
      var apellidos = document.forma01.apellidos.value;
      var correo = document.forma01.correo.value;
      var rol = document.forma01.rol.value;

      if((nombre == "") || (apellidos == "") || (correo == "") || (rol == 0)) {
        $('#mensaje').html('Faltan campos por llenar').css("color", "red");
        setTimeout("$('#mensaje').html('')",5000);
        return false;

      } else {
        return true;
      }
    }

    function validarCorreo() {
      var correo = $('#correo').val();
      if(correo) {
          $.ajax ({
                  url     : 'validar_correo.php',
                  type    : 'post',
                  datatype : 'text',
                  data    : 'correo='+correo,
                  success : function(res) {
                      if (res == 'correo_existente') {
                          $('#mensaje2').html('El correo ya existe').css("color", "red");
                          $('#correo').val('');
                      } else {
                          $('#mensaje2').html('Correo apropiado').css("color", "green");
                      }
                      setTimeout("$('#mensaje2').html('')", 5000);
              },error: function() {
                  alert('Error archivo no encontrado...');
              }
          });
      }
    }
</script>
</head>
<body>
<div class="detalle-empleado">
<div class="display-6" style="color: white;">Edición de empleado</div>
<div class="detalle-item"><a href="empleados_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
<form enctype="multipart/form-data" name="forma01" action="empleados_actualiza.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="detalle-item">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
    </div>
    <div class="detalle-item">
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>">
    </div>
    <div class="detalle-item">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" onblur="validarCorreo();" value="<?php echo $correo; ?>">
    </div>
    <div class="detalle-item">
        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="1" <?php if ($rol == 1) echo "selected"; ?>>Gerente</option>
            <option value="2" <?php if ($rol == 2) echo "selected"; ?>>Coordinador</option>
            <option value="3" <?php if ($rol == 3) echo "selected"; ?>>Especialista</option>
            <option value="4" <?php if ($rol == 4) echo "selected"; ?>>Recursos Humanos</option>
            <option value="5" <?php if ($rol == 5) echo "selected"; ?>>Ventas</option>
        </select>
    </div>
    <div class="detalle-item">
        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" placeholder="Nueva contraseña">
        <div>Ingresar contraseña, solo si desea cambiarla.</div>
    </div>

    <div class="detalle-item">
        <label for="foto">Foto de perfil:</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        <div>Seleccione una nueva foto de perfil si desea cambiarla.</div>
    </div>

    <button type="submit" onclick="return valida();" class="btn btn-success">Guardar</button>
</form>
<div id='mensaje'></div>
<div  id='mensaje2'></div>
</div>
</body>
</html>