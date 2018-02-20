<?php session_start();
$ftp_server = "localhost";
$ftp_user = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
$ftp_pass = filter_var($_POST['contrasena'], FILTER_SANITIZE_STRING);
echo $ftp_user . " " . $ftp_pass . "<br>";
// establecer una conexión o finalizarla
$conn_id = ftp_connect($ftp_server) or die("No se pudo conectar a $ftp_server"); 

// intentar iniciar sesión
if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    echo "Conectado como $ftp_user@$ftp_server\n";
} else {
    echo "No se pudo conectar como $ftp_user\n";
}

// cerrar la conexión ftp
ftp_close($conn_id);  
//require '../../index.html';
?>