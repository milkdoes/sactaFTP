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

//Cambiar directorio al directorio actual en el objeto FTP
$dir = $_POST['dir'];
$ftpObj -> changeDir($dir);

//Renombrar elemento
$oldName = $_POST['oldName'];
$newName = $_POST['newName'];

$ftpObj -> rename($oldName, $newName);

echo array_values(array_slice($ftpObj -> getMessages(), -1))[0];

//header('Location: ../../home.php');
?>