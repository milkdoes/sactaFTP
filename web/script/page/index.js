/*jshint esversion: 6 */
(function() {
	"use strict";

	// CONSTANTES.
	window.ARCHIVO_SUBIDA_FTP_ID = "#ArchivoSubidaFtp";
	window.SUBIR_ARCHIVO_ID = "#SubirArchivo";
	window.SUBIDA = "script/data/subirArchivo.php";

	// PRINCIPAL.
	$(document).ready(function() {
		$(window.SUBIR_ARCHIVO_ID).click(function() {
			// Obtener propiedades de archivo.
			const archivo = $(ARCHIVO_SUBIDA_FTP_ID).prop("files")[0];
			let dataForma = new FormData();
			dataForma.append("archivo", archivo);

			$.ajax({
				url: window.SUBIDA,
				dataType: 'script',
				cache: false,
				contentType: false,
				processData: false,
				// Setting the data attribute of ajax with file_data
				data: dataForma,
				type: 'post',
				success: function() {
					alert("Exito.");
				}
			});
		});
	});
}());
