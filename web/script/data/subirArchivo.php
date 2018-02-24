<?php
// Alertar todos los errores.
ini_set('display_errors', true);
error_reporting(E_ALL);

// Iniciar captura de despliegue.
ob_start();

// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// CONSTANTS.
define("EXECUTE_FILE", "conectarFtp.php");
// INPUT VALUES.
// Parametro de archivo a recibir.
define("ARCHIVO", "archivo");
// Ruta de directorio en el cual se estaran los archivos temporalmente antes de
// subir a servidor FTP.
define("DIR_TEMPORAL", '/home/vsftpd/ftp/temp/');

// MAIN.
// Obtener datos de archivo.
$archivo = $_FILES[ARCHIVO];
$nombreArchivo = basename($archivo['name']);
$rutaTemporal = $archivo['tmp_name'];
$rutaSubidaTemporal = DIR_TEMPORAL . $nombreArchivo;

// Subir archivo a ruta temporal.
$subidaWebExitosa = move_uploaded_file($rutaTemporal, $rutaSubidaTemporal);

// Si la subida es exitosa, continuar con subida a servidor FTP.
// Si no, desplegar mensaje de error.
$mensaje = "";
if ($subidaWebExitosa) {
	// Subir archivo a servidor FTP.
	require_once EXECUTE_FILE;
	$subidaFtpExitosa = SubirArchivo($ftpObj, $rutaSubidaTemporal);

	// Desplegar mensaje de estatus de subida a servidor FTP.
	$mensajeFtp = "al subir archivo a servidor FTP.";
	if ($subidaFtpExitosa) {
		$mensaje = "Exito " . $mensajeFtp;
	} else {
		$mensaje = "Fallo " . $mensajeFtp;
	}

	// Borrar archivo temporal.
	unlink($rutaSubidaTemporal);
} else {
	$mensaje = "Fallo al grabar archivo a folder temporal.";
}

// End, clear and get output capturing.
$debugOutput = ob_get_flush();

// Desplegar mensaje deseado.
echo $mensaje;
?>
