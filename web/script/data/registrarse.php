<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CONSTANTES.
define("USUARIO_FTP", "vsftpd");
define("RUTA_TERMINAL", "/bin/bash");
define("SCRIPT_CREACION", "creacionUsuarioVirtual.sh");

//Recibir valores de POST
$nombre = $_POST['nombre'];
$contrasena = $_POST['pass1'];

// Definir si la lista de parametros enviados son validos.
$parametrosValidos = empty($nombre) == false && empty($contrasena) == false;

// Definir json a retornar.
$json = array(
	"mensaje" => "Error al enviar parametros."
	, "codigoSalida" => 1
	, "parametrosEnviados" => json_encode($_REQUEST)
	, "mensajesTerminal" => array()
);

// Continuar creando/reemplazando usuario virtual si los parametros a usar son
// validos.
if ($parametrosValidos) {
	// Ejecutar creacion/reemplazo de usuario.
	$parametros = '"' . $nombre . '" "' . $contrasena . '"';
	$comando = "sudo -S " . RUTA_TERMINAL . " " .
		SCRIPT_CREACION . " $parametros 2>&1";
	exec($comando, $lineasSalida, $codigoSalida);
	$json["mensaje"] = "Script ejecutado.";
	$json["codigoSalida"] = $codigoSalida;
	$json["mensajesTerminal"] = implode("<br />", $lineasSalida);
}

// Desplegar json.
echo json_encode($json);
?> 
