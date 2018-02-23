<?php 
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inicio</title>
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
		<!-- Scripts. -->
		<script type="text/javascript" src="script/plugin/jquery.min.js"></script>
		<script type="text/javascript" src="script/plugin/materialize.min.js"></script>
		<script type="text/javascript" src="script/page/ini.js"></script>
		<script type="text/javascript" src="script/page/index.js"></script>
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
