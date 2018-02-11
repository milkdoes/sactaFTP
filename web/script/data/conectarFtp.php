<?php
// Alertar todos los errores.
ini_set('display_errors', true);
error_reporting(E_ALL);

// *** Define your host, username, and password.
define('FTP_HOST', 'localhost');
define('FTP_USER', 'sacta');
define('FTP_PASS', 'Sacta1');

// Definir ruta permitible para archivos.
define('RUTA_ARCHIVOS', '/archivos/');

// *** Include the class.
include('ftp_class.php');

// *** Create the FTP object.
$ftpObj = new FTPClient();

$conexion = $ftpObj -> connect(FTP_HOST, FTP_USER, FTP_PASS);

// *** Connect.
if ($conexion) {
	// *** Then add FTP code here.
	print_r($ftpObj -> getMessages());
} else {
	print_r($ftpObj -> getMessages());
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
