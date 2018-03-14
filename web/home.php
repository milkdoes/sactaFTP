<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

// // *** Include the class.
// include('script/data/ftp_class.php');

// // *** Create the FTP object.
// $ftpObj = new FTPClient();

// // *** Connect.
// $conexion = $ftpObj -> connect('localhost', $user, $pass);

// // CONSTANTS.
// //define("EXECUTE_FILE", "conectarFtp.php");

// //Cambiar directorio
// $dir = "/";

// // *** Get folder contents
// $contentsArray = $ftpObj->getDirListing($dir, '-laF');

// //Ordenar folders primero, archivos despues
// function cmp($a, $b) {
//     return (substr($a, -1) == "/" && substr($b, -1) != "/" || substr($a, 1) > substr($b, 1)) ? -1 : 1;
// }

// uasort($contentsArray, cmp);
 
// // *** Output our array of folder contents
// //print_r($contentsArray);

// // close the connection
// //tp_close($conexion);
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
		<div class="row center blue-grey darken-2">
			<div class="input-field col">
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">file_upload</i>Subir</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">file_download</i>Descargar</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">file_copy</i>Copiar</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">content_paste</i>Pegar</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">content_cut</i>Cortar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" href="#modal1"><i class="material-icons left white-text">create_new_folder</i>Nueva carpeta</a>
			</div>
		</div>
		<!--Desplegar archivos en directorio actual-->
		<div id="divArchivos">
		    <?php
		    	include("script/data/obtenerArchivos.php");
		    ?>
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
		<script>
			// $(".carpeta").on('click', function (){
			// 	console.log($(this).attr("id"));
			// 	var htmlData = $('#divArchivos').html();
			// 	$.post('script/data/obtenerArchivos.php', {'html': htmlData },function(response){
			//  	 		// response now contains anything echoed from processingscript.php 
			//  	 		dir: $(this).attr("id")
			// 	});
			// 	document.getElementById("divArchivos").html = htmlData;

			// 	// $.post("script/data/obtenerArchivos.php", { dir: $(this).attr("id")}).done(function(data, status){
			// 	// 	$("#divArchivos").empty();
			// 	// 	$("#divArchivos").append(data);
			// 	// });
			// });
			var arrayDirActual = ["/"];
			var dirActual = "";
			$(document).on('click', '.carpeta', function (){
				dirActual = "";
				if($(this).attr("id") == "../"){
					arrayDirActual.pop();
				}
				else {
				arrayDirActual.push($(this).attr("id"));
				}
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}
				console.log(dirActual);
				$.post("script/data/obtenerArchivos.php", { dir: dirActual }).done(function(data, status){
					$("#divArchivos").empty();
					$("#divArchivos").append(data);
				});
			});

			// function obtenerArchivos(){
			// 	console.log($(this).attr("id"));
			// 	var htmlData = $('#divArchivos').html();
			// 	$.post('script/data/obtenerArchivos.php', {'html': htmlData },function(response){
			//  	 		// response now contains anything echoed from processingscript.php 
			//  	 		dir: $(this).attr("id")
			// 	});
			// 	document.getElementById("divArchivos").html = htmlData;
			// }

			function subir(){
				document.getElementById("archivo").submit();
			}

		  	$(document).ready(function(){
		    	// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
		    	$('.modal').modal();

		    	if($("#divArchivos").text()== ""){
		    		$("#divArchivos").load("script/data/obtenerArchivos.php");
		    	}
				
		  	});   
		</script>
	</body>
</html>
