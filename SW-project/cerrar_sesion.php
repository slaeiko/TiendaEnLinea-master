<?php
//cerrar_sesion.php
// Inicia la sesión si no se ha iniciado aún
session_start();

// Destruye todas las variables de sesión
session_destroy();

// Redirige al usuario a index.php
header("Location: index.php");
exit();
?>
