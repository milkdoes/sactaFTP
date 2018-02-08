<?php
// *** Define your host, username, and password.
define('FTP_HOST', 'localhost');
define('FTP_USER', 'sacta');
define('FTP_PASS', 'Sacta1');

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

function SubirArchivo($ftpObj, $archivoSubida, $ruta = '/') {
	$ruta = $ruta . $archivoSubida;

	// *** Upload local file to new directory on server.
	$ftpObj -> uploadFile($archivoSubida, $ruta);
}


?>
