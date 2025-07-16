<!--empleados_alta.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alta de empleados</title>
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
      var password = document.forma01.pass.value;
      var rol = document.forma01.rol.value;
      var foto = document.forma01.foto.value;

      if((nombre == "") || (apellidos == "") || (correo == "") || (password == "") || (rol == 0) || (foto == "")) {
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
<?php 
    include 'menu.php'; 

    if (!isset($_SESSION['nombre'])) {
        // Si no está definida, redirige al usuario a la página de inicio de sesión
        header("Location: index.php");
        exit(); // Detiene la ejecución del script después de redirigir
    }
?>
<div class="detalle-empleado">
<div class="display-6" style="color: white;">Alta de empleados</div>
<div class="detalle-item"><a href="empleados_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
<form name="forma01" method="post" enctype="multipart/form-data" action="empleados_salva.php">
    <div class="detalle-item">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre">
    </div>
    <div class="detalle-item">
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos">
    </div>
    <div class="detalle-item">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" onblur="validarCorreo();">
    </div>
    <div class="detalle-item">
        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass">
    </div>
    <div class="detalle-item">
        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="">Seleccionar</option>
            <option value="1">Gerente</option>
            <option value="2">Coordinador</option>
            <option value="3">Especialista</option>
            <option value="4">Recursos Humanos</option>
            <option value="5">Ventas</option>
        </select>
    </div>

    <div class="detalle-item">
        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>
    </div>


    <button type="submit" onclick="return valida();" class="btn btn-success">Guardar</button>
</form>
<div id='mensaje'></div>
<div  id='mensaje2'></div>
</div>
</body>
</html>