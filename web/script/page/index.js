/* jshint esversion: 6 */
(function() {
	"use strict";

	// CONSTANTES.
	const PAGINA = "login.php";

	// MAIN.
	// Obtener URL actual.
	const urlActual = window.location.href;

	// Separar la ultima parte de la url.
	const separador = "/";
	let partesUrl = urlActual.split(separador);
	partesUrl.pop();
	const urlNueva = partesUrl.join(separador) + separador + PAGINA;

	// Redireccionar a pagina deseada.
	window.location.href = urlNueva;
}());
