<?php
//empleados_lista.php
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM empleados 
				WHERE status = 1 AND eliminado = 0";
$res = $con->query($sql);
$num = $res->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listado de empleados</title>
<link rel="stylesheet" type="text/css" href="css/styles_lista.css">
<!-- Enlace a Bootstrap CSS desde CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="js/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function() {
    $(".eliminar-empleado").click(function(e) {
        e.preventDefault();
        var empleadoID = $(this).data('id');
        if (confirm("¿Estas seguro de que deseas eliminar a este empleado?")) {
            $.ajax({
                url: 'empleados_elimina.php',
                type: 'post',
                data: { id: empleadoID },
                success: function(response) {
                    if (response == 'success') {
                        // Eliminar la fila correspondiente
                        $('#empleado_' + empleadoID).remove();
                    } else {
                        alert('Error al eliminar empleado');
                    }
                },
                error: function() {
                    alert('Error al conectar con el servidor');
                }
            });
        }
    });
});
</script>
</head>
<body>
<?php 
    include 'menu.php'; 

    if (!isset($_SESSION['nombre'])) {
        // Si no está definida, redirige al usuario a la página de inicio de sesión
        header("Location: index.php");
        exit();
    }
?>
<div class="separacion_menu">
<div class="display-4">Lista de empleados <?php //echo $num; ?></div>
<div style="text-align: right;">
    <a href="empleados_alta.php" class="btn btn-outline-success btn-sm">Crear nuevo registro</a>
</div>
<?php
while ($row = $res->fetch_array()) {
    $rol = "";
    switch ($row["rol"]) {
        case 1:
            $rol = "Gerente";
            break;
        case 2:
            $rol = "Coordinador";
            break;
        case 3:
            $rol = "Especialista";
            break;
        case 4:
            $rol = "Recursos Humanos";
            break;
        case 5:
            $rol = "Ventas";
            break;
        default:
            $rol = "Desconocido";
            break;
    }

    $id = $row["id"];
    $nombreCompleto = $row["nombre"] . ' ' . $row["apellidos"];
    $correo = $row["correo"];
?>
    <div class="empleado">
        <div class="id"><?php echo $id; ?></div>
        <div class="nombre"><?php echo $nombreCompleto; ?></div>
        <div class="correo"><?php echo $correo; ?></div>
		<div class="rol"><?php echo $rol; ?></div>

        <div class="accion"><a href="#" class="btn btn-danger eliminar-empleado" data-id="<?php echo $id; ?>">Eliminar</a></div>
        
        <div class="accion"><a href="empleados_detalle.php?id=<?php echo $id; ?>" class="btn btn-success">Ver Detalle</a></div>
        
        <div class="accion"><a href="empleados_editar.php?id=<?php echo $id; ?>" class="btn btn-warning">Editar</a></div>

    </div>
<?php
}
?>

</div>
</body>