<?php 
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inicio | SACTA FTP</title>
		<link rel="shortcut icon" href="img/logoSACTA_64x64.ico" type="image/x-icon"/>
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
		<br>
		<a class="waves-effect teal waves-light btn-flat white-text s1" href="#modalRegistrarse" id="btnNueva"><i class="material-icons left white-text">group_add</i>Registrarse</a>

		<h2 class="row center">Inicio de sesi&oacute;n</h2>
		<form action="script/data/loginCheck.php" method="POST">
			<!-- Usuario y contraseña. -->
			<div class="row center">
				<div class="input-field col s6 m6 l6 push-s3 push-m3 push-l3">
		          <input id="usuario" type="text" class="validate" name="usuario">
		          <label for="usuario">Usuario</label>
		        </div>
		    </div>
		    <div class="row center">
				<div class="input-field col s6 m6 l6 push-s3 push-m3 push-l3">
		          <input id="contrasena" type="password" class="validate " name="contrasena">
		          <label for="contrasena">Contrase&ntilde;a</label>
		        </div>
			</div>
			<div class="row center">
				<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
					<button class="btn waves-effect waves-light" type="submit" name="action">Conectarse
				    	<i class="material-icons right">send</i>
				  	</button>
				</div>
			</div>
			<?php
				if (isset($_SESSION['error']))
				{
				?>
				<div class="row center">
					<div class="card-panel red lighten-1 white-text"><?php echo $_SESSION['error'] ?>
					</div>
				</div>
				<?php
				    unset($_SESSION['error']);
				}
			?>
			<div id="footer"></div>
		</form>
		 <!-- Modal Crear Carpeta -->
		<div id="modalRegistrarse" class="modal">
			<form action="script/data/registrarse.php" onsubmit="return enviarCheck();"" method="POST">
			    <div class="modal-content">
			      	<h4>Registrarse</h4>
			      	<div class="input-field">
			            <input id="nombre" type="text" name="nombre" required> 
			            <label for="nombre">Nombre</label>		            
			        </div>
			        <div class="input-field">
			            <input id="pass1" type="password" name="pass1" required> 
			            <label for="pass1">Contrasena</label>		            
			        </div>
			        <div class="input-field">
			            <input id="pass2" type="password" name="pass2" required> 
			            <label for="pass2">Repita la contrasena</label>		            
			        </div>

			    </div>
			    <div class="modal-footer">
			    	<div class="input-field col s4 m4 l4 push-s4 push-m4 push-l4">
						<button class="btn waves-effect waves-light" type="submit" name="action">Registrarse
				  		</button>
					</div>
			      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
			    </div>
			</form>
		</div>
		<!-- Scripts. -->
		<script type="text/javascript" src="script/plugin/jquery.min.js"></script>
		<script type="text/javascript" src="script/plugin/materialize.min.js"></script>
		<script type="text/javascript" src="script/page/ini.js"></script>
		<script>
		function enviarCheck(){
			if($("#pass1").val() == $("#pass2").val() ){
				return true;

			} else {
				alert("La contraseña no es igual.")
				return false;
			}
		}
		$(document).ready(function(){

	    	// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
	    	$('.modal').modal();
			
	  	});  
		</script>
	</body>
</html>
<?php

function DestroySession()
{
	// Define if all operations are successful.
	$sucess = false;

	// Remove all session variables.
	$success = session_unset();

	// Destroy the session.
	$success = $success && session_destroy();

	// Return sucess of operations.
	return $success;
}

// Destruir sesion.
DestroySession();
?>
