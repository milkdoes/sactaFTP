<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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

//Borrar archivo
$archivos = $_POST['archivos'];
var_dump($_POST['archivos']);
foreach($archivos as $fileFrom){
	$tmp = explode("/", $fileFrom);
	$nombreArchivo = end($tmp);
	echo $nombreArchivo;
	$ftpObj -> downloadFile($nombreArchivo, "/home/luis/Downloads/" . $nombreArchivo);
	echo "/home/luis/Downloads" . $fileFrom;
}
//header('Location: ../../home.php');
?>