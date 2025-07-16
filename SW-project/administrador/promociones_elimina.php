<?php
//promociones_elimina.php
require "funciones/conecta.php";
$con= conecta();
$id= $_REQUEST['id'];
$sql= "UPDATE promociones SET eliminado= 1 WHERE id= $id";
//$res= $con->query($sql);
if ($con->query($sql) === TRUE) {
    echo 'success';
} else {
    echo 'error';
}
 ?>