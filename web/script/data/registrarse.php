<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Recibir valores de POST
$nombre = $_POST['nombre'];
$contrasena = $_POST['pass1'];

//Debugging
echo $nombre . " " . $contrasena;

//header('Location: ../../home.php');
?> 
