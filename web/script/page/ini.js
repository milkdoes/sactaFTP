/*jshint esversion: 6 */
(function() {
	"use strict";
	window.HEADER_ID = "#header";
    window.HEADERHOME_ID = "#headerHome";
	window.FOOTER_ID = "#footer";
	window.HEADERHOME_SOURCE = "part/header.php";
    window.HEADER_SOURCE = "part/header.html";
	window.FOOTER_SOURCE = "part/footer.html";
	window.COLLAPSE_ELEMENT_CLASS = ".button-collapse";

	$(document).ready(function() {
		// Cargar contenido a la cabecera.
		$(HEADERHOME_ID).load(HEADERHOME_SOURCE, function() {
			// Permitir dropdown para icono de menu.
			$(COLLAPSE_ELEMENT_CLASS).ready(function() {
				$(COLLAPSE_ELEMENT_CLASS).sideNav();
			});
		});
        
        $(HEADER_ID).load(HEADER_SOURCE, function() {
			// Permitir dropdown para icono de menu.
			$(COLLAPSE_ELEMENT_CLASS).ready(function() {
				$(COLLAPSE_ELEMENT_CLASS).sideNav();
			});
		});

		// Cargar contenido a pie de pagina.
		$(FOOTER_ID).load(FOOTER_SOURCE, function() {
		});
	});
}());
