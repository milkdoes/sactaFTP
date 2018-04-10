<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Recibir los valores del POST
$usuarioHuesped = $_POST['usuarioHuesped'];
$usuarioPatrocinador = $_POST['usuarioPatrocinador'];
$archivos = $_POST['archivos']; //Array de archivos

//Mensajes debug
echo $usuarioHuesped;
echo ' ' . $usuarioPatrocinador . ' ';
var_dump($archivos);

//Compartir archivos
//---Ejecutar el bash aqui---

?>