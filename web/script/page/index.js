/*jshint esversion: 6 */
(function() {
	"use strict";

	// CONSTANTES.
	window.ARCHIVO_SUBIDA_FTP_ID = "#ArchivoSubidaFtp";
	window.SUBIR_ARCHIVO_ID = "#SubirArchivo";

	// PRINCIPAL.
	$(document).ready(function() {
		$(window.SUBIR_ARCHIVO_ID).click(function() {
			// Obtener propiedades de archivo.
			const archivo = $(ARCHIVO_SUBIDA_FTP_ID).prop("files")[0];
		});
	});
}());
