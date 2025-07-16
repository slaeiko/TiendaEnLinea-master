<?php
// productos_editar.php

include 'menu.php'; 
// Verificar si hay una sesión iniciada
if (!isset($_SESSION['nombre'])) {
    // Si no hay una sesión iniciada, redirige al usuario a la página de inicio de sesión
    header("Location: index.php");
    exit();
} else {
    // Establecer el valor predeterminado de las variables del producto
    $nombre = '';
    $codigo = '';
    $descripcion = '';
    $costo = '';
    $stock = '';
}

require "funciones/conecta.php";
$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Obtener datos del producto para precargar el formulario
    $sql = "SELECT * FROM productos WHERE eliminado = 0 AND id = $id";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombre = $row["nombre"];
        $codigo = $row["codigo"];
        $descripcion = $row["descripcion"];
        $costo = $row["costo"];
        $stock = $row["stock"];
    } else {
        echo "No se encontró ningún producto con el ID proporcionado.";
        exit;
    }
} else {
    echo "Error: No se proporcionó un ID de producto válido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edición de producto</title>
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
    var descripcion = document.forma01.descripcion.value;
    var costo = document.forma01.costo.value;
    var stock = document.forma01.stock.value;
    var codigo = document.forma01.codigo.value;

    if (nombre === "" || descripcion === "" || costo === "" || stock === "" || codigo === "") {
        $('#mensaje').html('Faltan campos por llenar').css("color", "red");
        setTimeout(function() { $('#mensaje').html(''); }, 5000);
        return false;
    } else {
        return true;
    }
}

function validarCodigo() {
    var codigo = $('#codigo').val(); 
    if (codigo) { 
        $.ajax({
            url: 'validar_codigo.php',
            type: 'post',
            datatype: 'text',
            data: 'codigo=' + codigo, 
            success: function(res) {
                if (res == 'codigo_existente') { 
                    $('#mensaje2').html('El código ya existe').css("color", "red"); 
                    $('#codigo').val(''); // Limpiar el campo de código
                } else {
                    $('#mensaje2').html('Código apropiado').css("color", "green");
                }
                setTimeout(function() { $('#mensaje2').html(''); }, 5000);
            },
            error: function() {
                alert('Error archivo no encontrado...');
            }
        });
    }
}
</script>
</head>
<body>
<div class="detalle-empleado">
    <h1 class="display-6" style="color: white;">Edición de producto</h1>
    <div class="detalle-item"><a href="productos_lista.php" class="btn-regresar btn btn-outline-light">Regresar al listado </a></div>
    <form enctype="multipart/form-data" name="forma01" action="productos_actualiza.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="detalle-item">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
        </div>
        <div class="detalle-item">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" value="<?php echo $codigo; ?>" onblur="validarCodigo();">
            <div id='mensaje2'></div>
        </div>
        <div class="detalle-item">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>">
        </div>
        <div class="detalle-item">
            <label for="costo">Costo:</label>
            <input type="text" id="costo" name="costo" value="<?php echo $costo; ?>">
        </div>
        <div class="detalle-item">
            <label for="stock">Stock:</label>
            <input type="text" id="stock" name="stock" value="<?php echo $stock; ?>">
        </div>
        <div class="detalle-item">
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <div>Seleccione una nueva imagen si desea cambiarla.</div>
        </div>
        <button type="submit" onclick="return valida();" class="btn btn-success">Guardar</button>
    </form>
    <div id='mensaje'></div>
</div>
</body>
</html>
