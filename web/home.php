<?php
session_start();
$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

// *** Include the class.
include('script/data/ftp_class.php');
$ftpObj = new FTPClient();

// *** Create the FTP object.
$ftpObj = new FTPClient();

$conexion = $ftpObj -> connect('localhost', $user, $pass);

// *** Connect.
if ($conexion) {
	// *** Then add FTP code here.
	$colleccionMensajes = $ftpObj -> getMessages();
} else {
	$colleccionMensajes = $ftpObj -> getMessages();
}

// CONSTANTS.
define("EXECUTE_FILE", "conectarFtp.php");

// login with username and password
//$login_result = ftp_login($conexion, $user, $pass);

$dir = "/";
$ftpObj->changeDir($dir);
// get the file list for /
$buff = $ftpObj -> getDirListing();

// close the connection
//tp_close($conexion);

// output the buffer
var_dump($buff);
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
		              	<th>Tipo</th>
		              	<th>Fecha</th>
		          	</tr>
		        </thead>

		        <tbody>
	          		<?php 
	          		foreach($buff as $archivo){
						?>
						<tr>
							<td><?php echo $archivo ?></td>
		            		<td>?</td>
		            		<td>?</td>
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
