<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
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

// *** Get folder contents
$contentsArray = $ftpObj->getDirListing($dir, '-laF');
 
// *** Output our array of folder contents
//print_r($contentsArray);

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
				<a class="waves-effect waves-light btn-flat white-text" href="#modal1"><i class="material-icons left white-text">create_new_folder</i>Nueva carpeta</a>

			</div>
		</div>
		<!--Desplegar archivos en directorio actual-->
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
							<td><?php if(substr($datos[8], -1) == "/"){ echo '<i class="material-icons left gray-text text-darken-1 ">folder</i>'; };echo $datos[8]; ?></td>
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

      	<!--Subir archivo-->
      	<form action="script/data/subir.php" method="post" enctype="multipart/form-data" id="archivo">
      		<div class="file-field input-field">
				<div class="btn">
					<span>Archivo</span>
					<input type="file" name="fileToUpload" id="fileToUpload" onchange="subir()">
				</div>
				<div class="file-path-wrapper">
					<input type="submit" value="Subir archivo" name="submit" class="btn waves-effect waves-light">
				</div>
			</div>
                
        </form>

        <!-- Modals -->

		  <!-- Modal Crear Carpeta -->
		<div id="modal1" class="modal">
			<form action="script/data/nuevaCarpeta.php" method="POST">
			    <div class="modal-content">
			      	<h4>Crear nueva carpeta</h4>
			      	<div class="input-field">
			            <input id="nombreCarpeta" type="text" name="nombreCarpeta" required> 
			            <label for="nombreCarpeta">Nombre</label>
			            
			        </div>
			        <br>
			        <div class="input-field">
			            <input id="dir" type="text" value=<?php echo $dir; ?> name="dir" required>
			            <label for="dir">Directorio</label>
			        </div>
			    </div>
			    <div class="modal-footer">
			    	<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
						<button class="btn waves-effect waves-light" type="submit" name="action">Crear
				  		</button>
					</div>
			      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
			    </div>
			</form>
		</div>

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

		  	$(document).ready(function(){
		    	// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
		    	$('.modal').modal();
		  	});
          
		</script>
	</body>
</html>
