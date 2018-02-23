<?php
// Alertar todos los errores.
ini_set('display_errors', true);
error_reporting(E_ALL);

// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// *** Define your host, username, and password.
define('FTP_HOST', 'localhost');
define('FTP_USER', "ftp_user");
define('FTP_PASS', "ftp_pass");

$user = $_SESSION[FTP_USER];
$password = $_SESSION[FTP_PASS];

// Definir ruta permitible para archivos.
// Ruta raiz en configuracion de FTP.
define('RUTA_ARCHIVOS', "/");

// *** Include the class.
include('ftp_class.php');

// *** Create the FTP object.
$ftpObj = new FTPClient();

$conexion = $ftpObj -> connect(FTP_HOST, $user, $password);

// *** Connect.
if ($conexion) {
	// *** Then add FTP code here.
	$colleccionMensajes = $ftpObj -> getMessages();
} else {
	$colleccionMensajes = $ftpObj -> getMessages();
}

function SubirArchivo($ftpObj, $archivoSubida, $ruta = RUTA_ARCHIVOS) {
	// Definir exito al subir archivo.
	$exito = false;

	// Definir parametros para subida de archivo.
	$nombreArchivo = basename($archivoSubida);
	$ruta = $ruta . $nombreArchivo;

	// Subir archivo a servidor FTP y definir exito.
	$exito = $ftpObj -> uploadFile($archivoSubida, $ruta);

	// Regresar si la operacion tuvo exito o no.
	return $exito;
}


?>
