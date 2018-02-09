<?php
// CONSTANTS.
define("EXECUTE_FILE", "conectarFtp.php");
// INPUT VALUES.
define("ARCHIVO", "archivo");

// MAIN.
$archivo = $_FILES[ARCHIVO];

require_once EXECUTE_FILE;

SubirArchivo($ftpObj, $archivo);
?>
