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

//Cambiar directorio al directorio actual en la clase FTP
if(isset($_POST['dir'])){ 
	$dir = $_POST['dir'];
	$ftpObj -> changeDir($dir);
}

//Descargar archivo
$archivos = $_POST['archivos'];
var_dump($_POST['archivos']);
foreach($archivos as $fileFrom){
	$tmp = explode("/", $fileFrom);
	$nombreArchivo = end($tmp);
	echo $nombreArchivo;
	$ftpObj -> downloadFile($nombreArchivo, "/tmp/" . $nombreArchivo);
	echo "/tmp/" . $nombreArchivo;

	header("Content-disposition: attachment; filename=$nombreArchivo");
	header("Content-type: application/octet-stream");
	readfile("/tmp/" . $nombreArchivo);
}


//header('Location: ../../home.php');
?>