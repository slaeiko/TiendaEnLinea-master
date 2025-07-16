<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
<link rel="stylesheet" type="text/css" href="diseños.css">
<title>Mi Punto de Venta</title>
</head>
<body>
<header>
    <div class="logo">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['id_cliente'])) {
            $nombre = $_SESSION['nombre'];
            $apellido = $_SESSION['apellido'];
            $archivo = $_SESSION['archivo'];
            echo "<img src='$archivo' alt='Foto de perfil'>";
            echo "<p>Bienvenido, $nombre $apellido</p>";
        } else {
            echo "<img src='logoQM.png' alt='Logo'>";
            echo "<p>QuickMarket</p>";
        }
        ?>
    </div>

    <nav>
        <!-- Barra para la busqueda -->
        <form action="productos.php" method="GET" class="search-bar">
            <input 
                type="text" 
                id="busqueda" 
                name="busqueda" 
                placeholder="Buscar productos..." 
                autocomplete="off">
            <!-- Contenedor para las sugerencias -->
            <div id="sugerencias" class="sugerencias"></div>
        </form>

        <!-- Enlaces del menu -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="carrito01.php">Carrito</a></li>
            <?php
            if (isset($_SESSION['id_cliente'])) {
                echo '<li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li><a href="iniciar_sesion.php">Iniciar Sesión</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
<script>
    const inputBusqueda = document.getElementById('busqueda');
    const contenedorSugerencias = document.getElementById('sugerencias');

    inputBusqueda.addEventListener('input', () => {
        const termino = inputBusqueda.value;

        if (termino.length > 2) {
            // Realizar la solicitud AJAX
            fetch(autocompletar.php?term=${termino})
                .then(response => response.json())
                .then(data => {
                    // Limpiar las sugerencias previas
                    contenedorSugerencias.innerHTML = '';
                    data.forEach(producto => {
                        const div = document.createElement('div');
                        div.textContent = producto;
                        div.addEventListener('click', () => {
                            inputBusqueda.value = producto; // Completar el input
                            contenedorSugerencias.innerHTML = ''; // Limpiar sugerencias
                        });
                        contenedorSugerencias.appendChild(div);
                    });
                });
        } else {
            contenedorSugerencias.innerHTML = ''; // Limpiar si el termino es muy corto
        }
    });

    // Limpia las sugerencias si el input pierde el foco
    inputBusqueda.addEventListener('blur', () => {
        setTimeout(() => {
            contenedorSugerencias.innerHTML = '';
        }, 100); // Pequeño retraso para permitir clicks en las sugerencias
    });
</script>
</body>
</html>