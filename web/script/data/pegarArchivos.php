<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

// *** Include the class.
include('ftp_class.php');

// *** Create the FTP object.
$ftpObj = new FTPClient();

// *** Connect.
$conexion = $ftpObj -> connect('localhost', $user, $pass);

//Cambiar directorio al directorio actual en la clase FTP
$dir = $_POST['dir'];
echo $dir;
$ftpObj -> changeDir($dir);

$cortar = $_POST['cortar'];

//Pegar archivo
$archivos = $_POST['archivos'];
foreach($archivos as $archivo){
	$tmp = explode("/", $archivo);
	$nombreArchivo = end($tmp);
	$ftpObj -> copyPaste($archivo, $dir);
	if($cortar){
		$ftpObj -> deleteFile($archivo);
	}
}
//header('Location: ../../home.php');
?>