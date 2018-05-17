<?php
set_time_limit(0);
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$dir = $_POST['dir'];
$opcion = $_POST['opcion'];
$nuevoNombre = $_POST['nuevoNombre'];

$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

// *** Include the class.
include('ftp_class.php');

// *** Create the FTP object.
$ftpObj = new FTPClient();

// *** Connect.
$conexion = $ftpObj -> connect('localhost', $user, $pass);

//Subir archivo
$fileFrom = $_FILES["fileToUpload"]["tmp_name"];

//Si se esta subiendo un archivo con nombre repetido y se renombro
if($opcion == 'repetido'){
	$fileTo =  $dir . $nuevoNombre;
} else { 
	$fileTo =  $dir . basename($_FILES["fileToUpload"]["name"]);
}

$archivoSubido = false;
$archivoSubido = $ftpObj -> uploadFile($fileFrom, $fileTo);

echo $archivoSubido;
//header('Location: ../../home.php');
?>