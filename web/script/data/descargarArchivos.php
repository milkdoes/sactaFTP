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
if(isset($_POST['dirDescarga'])){ 
	$dir = $_POST['dirDescarga'];
	$ftpObj -> changeDir($dir);
}

//Descargar archivo
$archivos = $_POST['archivos'];
$arrayArchivos = explode("-", $archivos);
array_pop($arrayArchivos);

//Si es un solo archivo
if(count($arrayArchivos) == 1){

 	$tmp = explode("/", $arrayArchivos[0]);
	$nombreArchivo = end($tmp);
 	$ftpObj -> downloadFile($nombreArchivo, "/tmp/" . $nombreArchivo);

 	$nombre = '"' . $nombreArchivo . '"';


 	header("Content-Type: application/file");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Disposition: attachment; filename=$nombre");
  	readfile("/tmp/" . $nombreArchivo);

//Si son 2 o mas a descargar (ZIP)
} else {
	$nombreZip = $user . date("Y-m-d-h-i-s") . ".zip";
	$ejecutar = "zip -j /tmp/" . $nombreZip . " ";

	foreach ($arrayArchivos as $archivos) {
		$archivos = "'" . $archivos . "'";
		$ejecutar .=  "/home/vsftpd/ftp/". $user . $archivos . " ";
	}
	exec($ejecutar);

  	header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Disposition: attachment; filename=$nombreZip");
  	readfile("/tmp/" . $nombreZip);

}




//header('Location: ../../home.php');
?>