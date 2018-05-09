<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
<nav class="light-blue accent-4">
	<div class="nav-wrapper">
		<a href="login.php" class="brand-logo center">SACTA FTP</a>
		<a data-activates="mobile" class="button-collapse"><i class="material-icons">menu</i></a>
		<ul class="right hide-on-med-and-down">
			<li><a id="aUsername" href="#">Usuario:</a></li>
		</ul>
		<ul class="side-nav" id="mobile">
		</ul>
	</div>
</nav>
<script>
document.getElementById("aUsername").text = "Usuario: <?php echo $_SESSION['ftp_user']; ?>";
</script>