<?php
//index.php
require "funciones/conecta.php";
$con = conecta();

// Consulta para obtener 6 productos aleatorios activos y no eliminados
$sql = "SELECT * FROM productos WHERE status = 1 AND eliminado = 0 ORDER BY RAND() LIMIT 6";
$res = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio</title>
    <style> 
    /* Estilos del modal */ 
    .modal {
         display: none; 
         position: fixed; 
         z-index: 1; 
         left: 0; 
         top: 0; 
         width: 100%; 
         height: 100%; 
         overflow: auto; 
         background-color: rgb(0,0,0); 
         background-color: rgba(0,0,0,0.4); 
         padding-top: 60px; 
         } 
         
    .modal-content { 
        background-color: #fefefe; 
        margin: 5% auto; 
        padding: 20px; 
        border: 1px solid #888; 
        width: 80%; 
        } 

    .close { 
        color: #aaa; 
        float: right; 
        font-size: 28px; 
        font-weight: bold; 
        } 
    .close:hover, 
    .close:focus { 
        color: black; 
        text-decoration: none; 
        cursor: pointer; 
        } 
    .producto { 
        text-align: center; 
        } 
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <!-- Carrusel --> 
     <div class="carrusel"> 
        <div class="gallery js-flickity" data-flickity-options='{ "wrapAround":true, "pageDots": false, "autoPlay": true}'> 
            <?php $sqlPromociones = "SELECT archivo FROM promociones WHERE status = 1 AND eliminado = 0"; 
            $resPromociones = $con->query($sqlPromociones); 
            while ($rowPromociones = $resPromociones->fetch_assoc()) { 
            $archivo = $rowPromociones['archivo']; 
            echo "<div class='gallery-cell'>"; 
            echo "<img src='administrador/archivos/$archivo' alt=''>"; 
            echo "</div>"; 
            } ?> 
        </div> 
    </div>




    <section id="producto">
        <h2 style="text-align: center;">Productos</h2>
        <?php
        $contador = 0;
        echo '<div class="fila">';
        while ($row = $res->fetch_assoc()) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $archivo = $row['archivo'];

            echo '<div class="item">';
            echo "<a href='producto_detalle.php?id=$id'>";
            echo "<img src='administrador/archivos/$archivo' alt='$nombre'>";
            echo "<p>$nombre</p>";
            echo "</a>";
            echo '</div>';

            $contador++;
            if ($contador % 3 == 0 && $contador < 6) {
                echo '</div><div class="fila">';
            }
        }
        echo '</div>';
        ?>
    </section>

    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>


