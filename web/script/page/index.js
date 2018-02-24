/*jshint esversion: 6 */
(function() {
	"use strict";

	// CONSTANTES.
	window.ARCHIVO_SUBIDA_FTP_ID = "#ArchivoSubidaFtp";
	window.ARCHIVO_SUBIDA_FTP_TEXTO_ID = "#ArchivoSubidaFtpTexto";
	window.SUBIR_ARCHIVO_ID = "#SubirArchivo";
	window.SUBIDA = "script/data/subirArchivo.php";

	// PRINCIPAL.
	$(document).ready(function() {
		$(window.SUBIR_ARCHIVO_ID).click(function() {
			// Obtener propiedades de archivo.
			const archivo = $(ARCHIVO_SUBIDA_FTP_ID).prop("files")[0];
			let dataForma = new FormData();
			dataForma.append("archivo", archivo);

			// Subir archivo con llamada al servidor.
			$.ajax({
				url: window.SUBIDA,
				dataType: 'script',
				cache: false,
				contentType: false,
				processData: false,
				data: dataForma,
				type: 'post',
				success: function(mensaje) {
					// Alertar sobre estatus de subida.
					alert(mensaje);
				}, complete: function() {
					// Limpiar ingreso para archivo actual.
					$(window.ARCHIVO_SUBIDA_FTP_ID).val("");
					$(window.ARCHIVO_SUBIDA_FTP_TEXTO_ID).val("");
				}
			});
		});
	});
}());
