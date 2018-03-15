<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

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
		<link type="text/css" rel="stylesheet" href="css/home.css"/>
		<!-- Dejar que el navegador sepa que el sitio web está optimizado para dispositivos móviles. -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<div id="header"></div>
		<!--Botones de funciones FTP-->
		<div class="row center blue-grey darken-2">
				<form action="script/data/subir.php" method="post" enctype="multipart/form-data" id="archivo">
					<a class="file-field input-field waves-effect waves-light btn-flat white-text s1">
						<i class="material-icons left white-text">file_upload</i>Subir
						<input type="file" multiple name="fileToUpload" id="fileToUpload" onchange="subir()">
					</a>
					<input type="hidden" name="dir" value="/" id="dirSubir"/>
				</form>
				<!--<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">file_upload</i>Subir</a>-->
				<a class="waves-effect waves-light btn-flat white-text s1" onclick="descargarArchivos()"><i class="material-icons left white-text">file_download</i>Descargar</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">file_copy</i>Copiar</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">content_paste</i>Pegar</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">content_cut</i>Cortar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" href="#modal1"><i class="material-icons left white-text">create_new_folder</i>Nueva carpeta</a>
				<a class="waves-effect waves-light btn-flat white-text s1" href="#modal2" onclick="mostrarArchivosABorrar()"><i class="material-icons left white-text">delete</i>Borrar</a>
				<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">share</i>Compartir</a>
		</div>

		<!-- Directorio actual -->
		<div class="card-panel grey lighten-5 valign-wrapper" style="height: 10px">
			<span class="black-text text-darken-2" id="dir">/</span>
		</div>

		<!--Desplegar lista de archivos del directorio actual-->
		<div id="divArchivos">
		    <?php
		    	include("script/data/obtenerArchivos.php");
		    ?>
      	</div>

      	<!--Subir archivo-->
		<form action="script/data/subir.php" method="post" enctype="multipart/form-data" class="row">
			<div class="file-field input-field col s12 m8 l8">
					<div class="btn">
						<span>Archivo</span>
						<input type="file" multiple name="fileToUpload" id="fileToUpload">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
			</div>
			<div class="input-field col s12 m4 l4">
				<input type="submit" value="Subir archivo" class="btn waves-effect waves-light">
			</div>
			<input type="hidden" name="dir" value="/" id="dirSubir2"/>
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
			            <input id="dirNuevaCarpeta" type="text" value="/" name="dir" required>
			            <label for="dirNuevaCarpeta">Directorio destino</label>
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

		<!-- Modal Borrar Archivos -->
		<div id="modal2" class="modal">
		    <div class="modal-content">
		      	<h4>Borrar archivo</h4>
		        Los siguientes archivos se borrarán:
		      	<div id="archivosABorrar">          
		        </div>
		    </div>
		    <div class="modal-footer">
		    	<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
					<button class="btn waves-effect waves-light" name="action" onclick="borrarArchivos()">Borrar
			  		</button>
				</div>
		      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
		    </div>
		</div>

		<div id="footer"></div>
		<!-- Scripts. -->
		<script type="text/javascript" src="script/plugin/jquery.min.js"></script>
		<script type="text/javascript" src="script/plugin/materialize.min.js"></script>
		<script type="text/javascript" src="script/page/ini.js"></script>
		<script>
			var arrayDirActual = ["/"];
			var arrayElementosChecked = [];

			//Cambiar directorio actual
			$(document).on('click', '.carpeta', function (){
				arrayElementosChecked = [];
				var dirActual = "";
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
				document.getElementById("dir").innerHTML = dirActual;
				//Cambiar los inputs escondidos
				document.getElementById("dirSubir").value = dirActual;
				document.getElementById("dirSubir2").value = dirActual;
				document.getElementById("dirNuevaCarpeta").value = dirActual;
			});

			//Agregar/eliminar elementos al array de elementos seleccionados
			$(document).on('click', '.CBelemento', function (){
				var dirActual = "";
				aLen = arrayDirActual.length;

				//Armar directorio actual
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}
				
				//Comprobar si la propiedad checked es true o false
				console.log($(this).is(':checked') == true);
				if($(this).is(':checked') == true){
					//Agregar elemento/archivo a la lista
					arrayElementosChecked.push(dirActual + $(this).attr("id"));
				} else {
					//Borrar elemento/archivo de la lista
			        arrayElementosChecked = arrayElementosChecked.filter(e => e !== dirActual + $(this).attr("id"));

				}
				//Desplegar lista de elementos
				aLenE = arrayElementosChecked.length;
				var stringElementos = '';
				for (i = 0; i < aLenE; i++) {
			    	stringElementos += arrayElementosChecked[i] + ', ';
				}
				console.log(stringElementos);
			});

			function subir(){
				//Armar string de directorio actual
				var dirActual = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}
				
				
				//Hacer submit del form (post)
				document.getElementById("archivo").submit();
			}

			function descargarArchivos(){
				console.log("click!");
				$.post("script/data/descargarArchivos.php", { archivos: arrayElementosChecked }).done(function(data, status){
					// $("#divArchivos").empty();
					// $("#divArchivos").append(data);
					location.reload();
				});
			}

			function borrarArchivos(){
				$.post("script/data/borrarArchivos.php", { archivos: arrayElementosChecked }).done(function(data, status){
					location.reload();
				});
			}

			function mostrarArchivosABorrar(){
				//Obtener el div para mostrar los archivos
				var div = document.getElementById("archivosABorrar");
				div.innerHTML = "";

				//Desplegar lista de elementos
				aLenE = arrayElementosChecked.length;
				if(arrayElementosChecked[0] == undefined){
					div.innerHTML += "<p>No hay archivos seleccionados.</p>";
				} else {
					for (i = 0; i < aLenE; i++) {
				    	div.innerHTML += arrayElementosChecked[i] + '<br>';
					}
				}
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
