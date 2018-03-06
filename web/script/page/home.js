$(".carpeta").on("click", function (){
	console.log($(this).attr("id"));
	var htmlData = $('#divArchivos').html();
	$.post('../../obtenerArchivos.php', {'html': htmlData },function(response){
 	 		// response now contains anything echoed from processingscript.php 
 	 		dir: $(this).attr("id")
	});
	document.getElementById("divArchivos").html = htmlData;

	// $.post("script/data/obtenerArchivos.php", { dir: $(this).attr("id")}).done(function(data, status){
	// 	$("#divArchivos").empty();
	// 	$("#divArchivos").append(data);
	// });
});

function obtenerArchivos(){
	console.log($(this).attr("id"));
	var htmlData = $('#divArchivos').html();
	$.post('../../obtenerArchivos.php', {'html': htmlData },function(response){
 	 		// response now contains anything echoed from processingscript.php 
 	 		dir: $(this).attr("id")
	});
	document.getElementById("divArchivos").html = htmlData;
}