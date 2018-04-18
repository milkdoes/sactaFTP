<?php
// INSTRUCCIONES: Tener estas lineas al final del archivo "sudoers" para
// ejecutar correctamente.
/*
Defaults:vsftpd !requiretty
Defaults:www-data !requiretty
www-data ALL=(vsftpd) NOPASSWD: ALL
*/
// Linea de prueba:
// http://localhost/sactaftp/script/data/compartirArchivos.php?usuarioHuesped=user1&usuarioPatrocinador=pepe&archivos[]=macOS.jpg

// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONSTANTES.
define("USUARIO_FTP", "vsftpd");
define("RUTA_TERMINAL", "/bin/bash");
define("SCRIPT_COMPARTIR", "compartirParaUsuario.sh");

//Recibir los valores del POST
$usuarioHuesped = "";
$usuarioHuesped = $_REQUEST['usuarioHuesped'];
$usuarioPatrocinador = "";
$usuarioPatrocinador = $_REQUEST['usuarioPatrocinador'];
$archivos = array();
$archivos = $_REQUEST['archivos']; //Array de archivos

// Definir si la lista de parametros enviados son validos.
$parametrosValidos = empty($usuarioHuesped) == false &&
	empty($usuarioPatrocinador) == false && empty($archivos) == false;

// Continuar compartiendo archivos si los parametros a usar son validos.
$json = array(
	"mensaje" => "Error al enviar parametros."
	, "codigoSalida" => 1
	, "parametrosEnviados" => json_encode($_REQUEST)
	, "mensajesTerminal" => array()
);

if ($parametrosValidos) {
	// Definir lista de archivos como una sola linea de texto.
	//$listaArchivos = implode("' '", $archivos);
	//$listaArchivos = "'" . $listaArchivos . "'";
	//echo $listaArchivos;
	// Definir lista de parametros.
	//$parametros = "$usuarioHuesped $usuarioPatrocinador $listaArchivos";

	//echo "<br>" . $parametros;

	// Ejecutar compartimiento de archivos.
	foreach($archivos as $archivo){
		$archivo = "'" . $archivo . "'";
		$parametros = "$usuarioHuesped $usuarioPatrocinador $archivo";
		exec("sudo -u " . USUARIO_FTP . " " . RUTA_TERMINAL . " " . SCRIPT_COMPARTIR .  " $parametros 2>&1", $lineasSalida, $codigoSalida);
		$json["mensaje"] = "Script ejecutado.";
		$json["codigoSalida"] = $codigoSalida;
		$json["mensajesTerminal"] = implode("<br />", $lineasSalida);
	}
	
	
}

// Desplegar json.
echo json_encode($json);
?>
