<?php 
session_start();
$ftp_server = "localhost";
$ftp_user = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
$ftp_pass = filter_var($_POST['contrasena'], FILTER_SANITIZE_STRING);

//echo $ftp_user . " " . $ftp_pass . "<br>";
// establecer una conexión o finalizarla
$conn_id = ftp_connect($ftp_server);// or die($errorConexion = true);

if($conn_id == false){
	$_SESSION['error'] = "No se pudo conectar a $ftp_server";
	echo '
	<script>
	window.location.replace("../../login.php");
	</script>
	';
} else {
	// intentar iniciar sesión
	if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
	    //echo "Conectado como $ftp_user@$ftp_server\n";
	    $_SESSION['ftp_user'] = $ftp_user;
	    ftp_close($conn_id);
	    echo '
		<script>
		window.location.replace("../../angular/index.html");
		</script>
		';
	} else {
	    //echo "No se pudo conectar como $ftp_user\n";
	    ftp_close($conn_id);
	    $_SESSION['error'] = "Usuario y/o contrase&ntilde;a incorrecta.";
	    echo '
		<script>
		window.location.replace("../../login.php");
		</script>
		';
	}
}
?>