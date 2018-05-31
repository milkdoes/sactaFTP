<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(!isset($_SESSION['ftp_user'])){ //Si no hay un usuario en sesion
	header('Location: login.php');
}

$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home | SACTA FTP</title>
		<link rel="shortcut icon" href="img/logoSACTA_64x64.ico" type="image/x-icon"/>
		<meta charset="utf-8">
		<!-- Importar iconos de google.-->
		<!-- <link href="img/MaterialIcons-Regular.tff" rel="stylesheet"> -->
		<link type="text/css" rel="stylesheet" href="css/material-icons.css"/>
		<!-- Importar materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/home.css"/>
		<!-- Dejar que el navegador sepa que el sitio web está optimizado para dispositivos móviles. -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
        <div id="headerHome"></div>
		<!--Botones de funciones FTP-->
		<div class="row center blue-grey darken-2">
				<form action="script/data/subir.php" method="post" enctype="multipart/form-data" id="archivo">
					<a class="file-field input-field waves-effect waves-light btn-flat white-text s1"  id="btnSubir">
						<i class="material-icons left white-text">file_upload</i>Subir
						<input type="file" name="fileToUpload" id="fileToUpload" onchange="comprobarNombreSubir()">
						<input id="ArchivoSubidaFtpTexto" class="file-path validate" type="hidden">
					</a>
					<input type="hidden" name="dir" value="/" id="dirSubir"/>
				</form>
				<!--<a class="waves-effect waves-light btn-flat white-text s1"><i class="material-icons left white-text">file_upload</i>Subir</a>-->
				<a class="waves-effect waves-light btn-flat white-text s1" onclick="descargarArchivos()" id="btnDescargar"><i class="material-icons left white-text">file_download</i>Descargar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" onclick="copiarArchivos()" id="btnCopiar"><i class="material-icons left white-text">content_copy</i>Copiar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" onclick="cortarArchivos()" id="btnCortar"><i class="material-icons left white-text">content_cut</i>Cortar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" onclick="pegarArchivos()" id="btnPegar"><i class="material-icons left white-text">content_paste</i>Pegar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" href="#modalCrearCarpeta" id="btnNuevaCarpeta"><i class="material-icons left white-text">create_new_folder</i>Nueva carpeta</a>
				<a class="waves-effect waves-light btn-flat white-text s1" href="#modalBorrar" onclick="mostrarArchivosABorrar()" id="btnBorrar"><i class="material-icons left white-text">delete</i>Borrar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" href="#modalRenombrar" id="btnRenombrar"><i class="material-icons left white-text">edit</i>Renombrar</a>
				<a class="waves-effect waves-light btn-flat white-text s1" href="#modalCompartir" onclick="mostrarArchivosACompartir()" id="btnCompartir"><i class="material-icons left white-text">share</i>Compartir</a>
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

        <!-- Modals -->

		  <!-- Modal Crear Carpeta -->
		<div id="modalCrearCarpeta" class="modal">
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
		<div id="modalBorrar" class="modal">
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

		<!-- Modal Renombrar archivo -->
		<div id="modalRenombrar" class="modal">
			<!--<form action="script/data/renombrar.php" method="POST">-->
			    <div class="modal-content">
			      	<h4>Renombrar Archivo</h4>
			      	Nombre antiguo:
			      	<div class="input-field" id="nombreAntiguo">          
			        </div>
			      	<div class="input-field">
			            <input id="nombreNuevo" type="text" name="nombreNuevo" value="Nombre nuevo aqui"required> 
			            <label for="nombreNuevo">Nombre nuevo</label>		            
			        </div>  	
			    </div>
			    <div class="modal-footer">
			    	<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
						<button class="btn waves-effect waves-light" name="action" onclick="renombrar()">Renombrar
				  		</button>
					</div>
			      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
			    </div>
			<!--</form>-->
		</div>

		<!-- Modal Compartir archivos -->
		<div id="modalCompartir" class="modal">
			<!--<form action="script/data/compartir.php" method="POST">-->
			    <div class="modal-content">
			      	<h4>Compartir Archivos</h4>
			      	<div class="input-field">
			            <input id="usuarioPatrocinador" type="text" name="usuarioPatrocinador" required> 
			            <label for="usuarioPatrocinador">Usuario patrocinador</label>		            
			        </div>
				    Se compartir&aacute;n los siguientes archivos:
			      	<div id="archivosACompartir">          
			        </div>
			    </div>
			    <div class="modal-footer">
			    	<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
						<button class="btn waves-effect waves-light" name="action" onclick="compartirArchivos()">Compartir
				  		</button>
					</div>
			      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
			    </div>
			<!--</form>-->
		</div>

		<!-- Modal Subir archivo repetido -->
		<div id="modalSubirRepetido" class="modal">
			<!--<form action="script/data/compartir.php" method="POST">-->
			    <div class="modal-content">
			      	<h4>Subir Archivo</h4>
			      	El archivo <span id="spanArchivoRepetido">nombre archivo</span> ya existe en esta carpeta. Selecciona una opci&oacute;n:
			    	<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4 no-uppercase">
						<button class="btn waves-effect waves-light no-uppercase" name="action" onclick="subir()">Remplazar
				  		</button>
					</div>
					<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
						<button class="modal-action modal-close btn waves-effect waves-light no-uppercase" name="action">No subir
				  		</button>
					</div>
					<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
						<button class="btn waves-effect waves-light no-uppercase" name="action" onclick="subir('repetido')">Mantener los dos archivos (subir como <span id="spanNuevoNombre">nombrearchivo.txt</span>)
				  		</button>
					</div>
			    </div>
			    <div class="modal-footer">
			      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
			    </div>
			<!--</form>-->
		</div>

		<form action="script/data/descargarArchivos.php" method="post" enctype="multipart/form-data" id="descargarArchivos" hidden>
			<input type="text" name="archivos" id ="archivos">
			<input type="text" name="dirDescarga" id ="dirDescarga">
		</form>

		<!-- Div de subida en proceso al subir un archivo -->
		<div class="row" id="divSubida">
		    <div class="col s12 m5">
		        <div class="card-panel gray">
		          	<span class="blue-text">Subida en proceso...
		          	</span>
		          	<div class="progress">
					    <div class="indeterminate"></div>
					</div>
		        </div>
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
			var arrayElementosCopiados = [];
			var dirCopiados = "";
			var cortar = false;
			var arrayArchivosEnCarpeta = [];
			actualizarBotones();

			//Para funciones de renombrado de elementos
			function basename(str, sep) { //Regresa el nombre del archivo de una ruta dada
				if(str.endsWith("/")){
					str = str.slice(0, -1);
				}
			    return str.substr(str.lastIndexOf(sep) + 1);
			}

			function strip_extension(str) { //Regresa el nombre del archivo sin la extension
			    return str.substr(0,str.lastIndexOf('.'));
			}

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
				console.log("Directorio actual: " + dirActual);
				obtenerArchivos();
				document.getElementById("dir").innerHTML = dirActual;

				//Cambiar los inputs escondidos
				document.getElementById("dirSubir").value = dirActual;
				document.getElementById("dirNuevaCarpeta").value = dirActual;

				actualizarBotones();
			});

			//Cada vez que seleccionas un elemento (check/uncheck)
			$(document).on('change', '.CBelemento', function (){
				
				//Armar directorio actual
				var dirActual = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}
				
				//Comprobar si la propiedad checked es true o false
				console.log("Checked?: " + $(this).is(':checked'));
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
				console.log("Elementos checked: " + stringElementos);

				if(aLenE != 0){
					console.log("Elemento a renombrar mostrado");
					mostrarElementoARenombrar();
				}
				
				actualizarBotones();
			});

			function comprobarNombreSubir(){
				//Obtener el nombre del archivo a subir
				var rutaFileToUpload = $("#fileToUpload").val().split("\\");
				var fileToUpload = rutaFileToUpload[rutaFileToUpload.length-1];
				
				//Comprobar si hay un archivo que se llame igual al que se quiere subir
				if(arrayArchivosEnCarpeta.includes(fileToUpload)){
					//Escribir el nombre del archivo en el modal
					$("#spanArchivoRepetido").text(fileToUpload);

					//Generar nuevo nombre con numero
					var n = 1;
					var nombreValido = false;
					var nuevoNombre = "";
					while(nombreValido == false){
						n++;
						rutaFileToUpload = fileToUpload.split(".");

						var dotIndex = fileToUpload.lastIndexOf(".");
						//Renombrar el archivo con un numero y parentesis
					    if (dotIndex == -1) { 
					    	nuevoNombre = fileToUpload + "(" + n + ")" 
					    } else {
					    	nuevoNombre = fileToUpload.substring(0, dotIndex) + "(" + n + ")" + fileToUpload.substring(dotIndex);
					    }

					    //Si el nuevo nombre generado tambien en la carpeta
					    if(arrayArchivosEnCarpeta.includes(nuevoNombre)){
					    	//Repite el ciclo

					    } else {
					    	//Rompe el ciclo
					    	nombreValido = true;
					    }
					}

					//Escribir el nombre nuevo del archivo a subir
					$("#spanNuevoNombre").text(nuevoNombre);

					//Abrir el modal
					$('#modalSubirRepetido').modal('open');
				} else {
					subir();
				}
			}

			function subir(opcion){
				//Cerrar modal de subir archivo repetido
				$('#modalSubirRepetido').modal('close');
				//Mostrar div subida en proceso
				$("#divSubida").show();
				//Armar string de directorio actual
				var dirActual = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}
				//var fileToUpload = $("#fileToUpload").value;

				//Hacer submit del form (post)
				//document.getElementById("archivo").submit();

				// Obtener propiedades de archivo.
				var archivo = $("#fileToUpload").prop("files")[0];

				//Si la opcion de subida es mantener los dos archivos
				var nuevoNombre = "";
				if(opcion == 'repetido'){
					//Asignar nuevo nombre
					nuevoNombre = $("#spanNuevoNombre").text();
				}

				let dataForma = new FormData();
				dataForma.append("fileToUpload", archivo);
				dataForma.append("dir", dirActual);
				dataForma.append("opcion", opcion);
				dataForma.append("nuevoNombre", nuevoNombre);

				// Subir archivo con llamada al servidor.
				$.ajax({
					url: "script/data/subir.php",
					dataType: 'script',
					cache: false,
					contentType: false,
					processData: false,
					data: dataForma,
					type: 'post',
					success: function(mensaje) {
						// Alertar sobre estatus de subida.
						//alert(mensaje);
						obtenerArchivos();
						arrayElementosChecked = [];
						$('#modalRenombrar').modal('close'); //Cierra el modal Renombrar
						actualizarBotones();
						if(mensaje == "1"){
							//Mostrar mensaje con nombre de archivo
							if(opcion == 'repetido') //Si es un nombre generado
							{
								Materialize.toast("Archivo " + nuevoNombre + " subido correctamente.", 4000);
							} else { //Si no se genero ningun nombre
								Materialize.toast("Archivo " + $("#ArchivoSubidaFtpTexto").val() + " subido correctamente.", 4000);
							}
						} else { Materialize.toast("Error al subir " + $("#ArchivoSubidaFtpTexto").val() + ".", 4000); }
						
					}, complete: function() {
						$("#divSubida").hide();
						$("#ArchivoSubidaFtpTexto").val(" ");
						// // Limpiar ingreso para archivo actual.
						// $(window.ARCHIVO_SUBIDA_FTP_ID).val("");
						// $(window.ARCHIVO_SUBIDA_FTP_TEXTO_ID).val("");
					}
				});

			}

			function descargarArchivos(){
				//Armar directorio actual
				var dirActual = "";
				var archivos = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}

				sLen = arrayElementosChecked.length;
				for (i = 0; i < sLen; i++) {
			    	archivos += arrayElementosChecked[i];
			    	archivos += "@.@";
				}
				document.getElementById("dirDescarga").value = dirActual;
				document.getElementById("archivos").value = archivos;
				document.getElementById("descargarArchivos").submit();
			}

			function borrarArchivos(){
				$.post("script/data/borrarArchivos.php", { archivos: arrayElementosChecked }).done(function(data, status){
					//$("#divArchivos").empty();
					//$("#divArchivos").append(data);
					//location.reload();
					obtenerArchivos();
					arrayElementosChecked = [];
					$('#modalBorrar').modal('close'); //Cierra el modal Borrar
					document.getElementById("archivosABorrar").innerHTML = ""; // Borra el texto del modal
					actualizarBotones();
				});
			}

			function compartirArchivos(){
				usuarioPatrocinador = document.getElementById("usuarioPatrocinador").value;
				$.post("script/data/compartirArchivos.php", { usuarioHuesped: '<?php echo $user ?>', usuarioPatrocinador: usuarioPatrocinador, archivos: arrayElementosChecked }).done(function(data, status){
					//$("#divArchivos").empty(); $("#divArchivos").append(data);
					location.reload();
				});
			}

			function renombrar(){
				nombreNuevo = document.getElementById("nombreNuevo").value;

				//Armar directorio actual
				var dirActual = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}

				$.post("script/data/renombrar.php", { dir: dirActual, oldName: basename(arrayElementosChecked[0] ,'/'), newName: nombreNuevo }).done(function(data, status){
					//$("#divArchivos").empty();
					//$("#divArchivos").append(data);
					//location.reload();
					Materialize.toast(data, 4000);
					obtenerArchivos();
					arrayElementosChecked = [];
					$('#modalRenombrar').modal('close'); //Cierra el modal Renombrar
					actualizarBotones();
				});
			}

			function copiarArchivos(){
				//Guardar lista de elementos a copiar
				arrayElementosCopiados = arrayElementosChecked;
				//Guardar directorio de elementos a copiar
				dirCopiados = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirCopiados += arrayDirActual[i];

				}
				console.log("dirCopiados: " + dirCopiados);
				actualizarBotones();
				cortar = "false";

			}

			function cortarArchivos(){
				//Guardar lista de elementos a copiar
				arrayElementosCopiados = arrayElementosChecked;
				//Guardar directorio de elementos a copiar
				dirCopiados = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirCopiados += arrayDirActual[i];
				}
				actualizarBotones();
				cortar = "true";

			}

			function pegarArchivos(){
				//Armar directorio actual
				var dirActual = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}
				$.post("script/data/pegarArchivos.php", { archivos: arrayElementosCopiados, dirCopiados: dirCopiados, dirDestino: dirActual, cortar: cortar }).done(function(data, status){
					//$("#divArchivos").empty();
					//$("#divArchivos").append(data);
					//location.reload();
					//Materialize.toast(data);
					obtenerArchivos();
					arrayElementosCopiados = [];
					arrayElementosChecked = [];
					dirCopiados = "";
					cortar = "false";
					actualizarBotones();
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

			function mostrarElementoARenombrar(){
				//Obtener el div para mostrar el nombre del elemento
				var div = document.getElementById("nombreAntiguo");

				//Desplegar el elemento
				if(arrayElementosChecked[0] == undefined){
					div.innerHTML += "<p>No hay un archivo seleccionado.</p>";
				} else {
				    	div.innerHTML = basename(arrayElementosChecked[0] ,'/');
				}

				//Obtener el input para mostrar el nombre del elemento
				document.getElementById("nombreNuevo").value = basename(arrayElementosChecked[0] ,'/');
			}

			function mostrarArchivosACompartir(){
				//Obtener el div para mostrar los archivos
				var div = document.getElementById("archivosACompartir");
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

			//Guardar los elementos de los botones de las funciones en variables
			var btnSubir = document.getElementById("btnSubir");
			var btnDescargar = document.getElementById("btnDescargar");
			var btnCopiar = document.getElementById("btnCopiar");
			var btnPegar = document.getElementById("btnPegar");
			var btnCortar = document.getElementById("btnCortar");
			var btnNuevaCarpeta = document.getElementById("btnNuevaCarpeta");
			var btnBorrar = document.getElementById("btnBorrar");
			var btnCompartir = document.getElementById("btnCompartir");
			var btnRenombrar = document.getElementById("btnRenombrar");


			function actualizarBotones(){ //Mostrar/ocultar botones de funciones
				aLen = arrayElementosChecked.length;

				if(aLen == 0){ //Cuando no hay elementos seleccionados
					$(btnDescargar).hide();
					$(btnCopiar).hide();
					$(btnCortar).hide();
					$(btnPegar).hide();
					$(btnBorrar).hide();
					$(btnCompartir).hide();
					$(btnRenombrar).hide();
				}

				if(aLen != 0){ //Cuando hay por lo menos un elemento seleccionado
					$(btnDescargar).show();
					$(btnCopiar).show();
					$(btnCortar).show();
					$(btnBorrar).show();
					$(btnCompartir).show();
				}

				if(arrayElementosCopiados.length != 0){ //Si se copio o se corto un elemento
					$(btnPegar).show();
				}

				if(aLen == 1){
					$(btnRenombrar).show();
				}

				if(aLen > 1){
					$(btnRenombrar).hide();
				}

				//Si alguno de los elementos seleccionados es una carpeta
				var carpetaSeleccionada = false;
				for (i = 0; i < aLen; i++) {
			    	if(arrayElementosChecked[i].endsWith("/")){
			    		carpetaSeleccionada = true;
			    		break;
			    	}
				}
				if(carpetaSeleccionada == true){
					$(btnCopiar).hide();
					$(btnCortar).hide();
					//$(btnDescargar).hide();
				}

			}

			function obtenerArchivos(){
				//Armar directorio actual
				var dirActual = "";
				aLen = arrayDirActual.length;
				for (i = 0; i < aLen; i++) {
			    	dirActual += arrayDirActual[i];
				}

				$.post("script/data/obtenerArchivos.php", { dir: dirActual }).done(function(data, status){
					$("#divArchivos").empty();
					$("#divArchivos").append(data);
					arrayArchivosEnCarpeta = $("#archivosEnCarpeta").val().split(";");
				});
			}

		  	$(document).ready(function(){
		  		actualizarBotones();

		  		$("#divSubida").hide(); //Esconder el div de mensaje al subir un archivo.

		    	// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
		    	$('.modal').modal();

		    	obtenerArchivos();
				
		  	});   
		</script>
		
	</body>
</html>
