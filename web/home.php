<?php
session_start();
$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

// *** Include the class.
include('script/data/ftp_class.php');

// *** Create the FTP object.
$ftpObj = new FTPClient();

// *** Connect.
$conexion = $ftpObj -> connect('localhost', $user, $pass);

// CONSTANTS.
//define("EXECUTE_FILE", "conectarFtp.php");

//Cambiar directorio
$dir = "/";

//$dir = "/home/vsftpd/ftp/fer/";
//$ftpObj->changeDir($dir);
print_r($ftpObj -> getMessages());

// *** Get folder contents
$contentsArray = $ftpObj->getDirListing($dir);
 
// *** Output our array of folder contents
print_r($contentsArray);
// close the connection
//tp_close($conexion);

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<meta charset="utf-8">
		<!-- Importar iconos de google.-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- Importar materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
		<!-- Dejar que el navegador sepa que el sitio web está optimizado para dispositivos móviles. -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<div id="header"></div>
		<div class="row center card-panel blue-grey darken-2">
			
			<div class="input-field col">
				<a class="waves-effect waves-light btn-flat white-text"><i class="material-icons left white-text">file_upload</i>Subir</a>
				<a class="waves-effect waves-light btn-flat white-text"><i class="material-icons left white-text">file_download</i>Descargar</a>
				<a class="waves-effect waves-light btn-flat white-text"><i class="material-icons left white-text">file_copy</i>Copiar</a>
				<a class="waves-effect waves-light btn-flat white-text"><i class="material-icons left white-text">content_paste</i>Pegar</a>
				<a class="waves-effect waves-light btn-flat white-text"><i class="material-icons left white-text">content_cut</i>Cortar</a>

			</div>
		</div>
		<div>
		     <table>
		        <thead>
		          	<tr>
		              	<th>Nombre</th>
		              	<th>Tama&ntilde;o</th>
		              	<th>&Uacute;ltima modificaci&oacute;n</th>
		              	<th>Permisos</th>

		          	</tr>
		        </thead>

		        <tbody>
	          		<?php 
	          		foreach($contentsArray as $archivo){
	          			$datos = preg_split('/\s+/', $archivo);
						?>
						<tr>
							<td><?php echo $datos[8] ?></td>
							<td><?php echo human_filesize($datos[4]) ?></td>
		            		<td><?php echo $datos[5] . ' ' . $datos[6] . ' ' . $datos[7]?></td>
		            		<td><?php echo $datos[0] ?></td>
	            		</tr>
						<?php
					}
	          		?>
		        </tbody>
		    </table>
      	</div>

      	<form action="script/data/subir.php" method="post" enctype="multipart/form-data" id="archivo">
      		<div class="file-field input-field">
			<div class="btn">
				<span>Archivo</span>
				<input type="file" name="fileToUpload" id="fileToUpload" onchange="subir()">
			</div>
			<div class="file-path-wrapper">
				<input type="submit" value="Subir archivo" name="submit" class="btn waves-effect waves-light">

				</button>
			</div>
		</div>
                
                
        </form>

		<div id="footer"></div>
		<!-- Scripts. -->
		<script type="text/javascript" src="script/plugin/jquery.min.js"></script>
		<script type="text/javascript" src="script/plugin/materialize.min.js"></script>
		<script type="text/javascript" src="script/page/ini.js"></script>
		<script type="text/javascript" src="script/page/index.js"></script>
		<script>
			function subir(){
				document.getElementById("archivo").submit();
			}
		</script>
	</body>
</html>
