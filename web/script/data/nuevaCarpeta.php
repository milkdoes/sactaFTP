<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$nombreCarpeta = $_POST['nombreCarpeta'];
echo $nombreCarpeta;
$dir = $_POST['dir'];
echo $dir;

$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

// *** Include the class.
include('ftp_class.php');

// *** Create the FTP object.
$ftpObj = new FTPClient();

// *** Connect.
$conexion = $ftpObj -> connect('localhost', $user, $pass);

//Crear carpeta
$conexion = $ftpObj -> makeDir($dir . $nombreCarpeta);

header('Location: ../../home.php');

?>