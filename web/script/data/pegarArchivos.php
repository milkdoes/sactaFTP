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

// Mensajes debug
$dirCopiados = $_POST['dirCopiados'];
echo '<br>$dirCopiados: ' . $dirCopiados;

$dirDestino = $_POST['dirDestino'];
echo '$dirDestino: ' . $dirDestino;

$cortar = $_POST['cortar'];
echo '<br>$cortar: ' . $cortar;

//Pegar archivo
$archivos = $_POST['archivos'];

foreach($archivos as $archivo){
	echo '<br>$archivo: ' . $archivo;
	$tmp = explode("/", $archivo);
	$nombreArchivo = end($tmp);
	echo '<br>$nombreArchivo: ' . $nombreArchivo;
	$ftpObj -> copyPaste($nombreArchivo, $dirCopiados, $dirDestino);
	if($cortar == "true"){ //Si la opcion de pegado es cortar
		$ftpObj -> changeDir($dirCopiados);
		$ftpObj -> deleteFile($nombreArchivo); //Borrar el archivo original
	}
	echo '<br>getMessages(): ';
	var_dump($ftpObj -> getMessages());
}
//header('Location: ../../home.php');
?>