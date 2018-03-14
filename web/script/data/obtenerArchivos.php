<?php
// Start session if it has not already started.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
$user = $_SESSION['ftp_user'];
$pass = $_SESSION['ftp_pass'];

// *** Include the class.
include('ftp_class.php');

// *** Create the FTP object.
$ftpObj = new FTPClient();

// *** Connect.
$conexion = $ftpObj -> connect('localhost', $user, $pass);

//Cambiar directorio
$dir = "/";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST['dir'])){ 
		$dir = $_POST['dir'];
    $ftpObj -> changeDir($dir);
	}
}

// *** Get folder contents
$contentsArray = $ftpObj->getDirListing($dir, '-laF');

//Ordenar folders primero, archivos despues, alfabeticamente
// function cmp($a, $b) {
//   return (substr($a, -1) == "/" && substr($b, -1) != "/") ? -1 : 1;
// }

function cmp($a, $b) {
  if(substr($a, -1) == "/" && substr($b, -1) == "/"){
    $datosA = preg_split('/\s+/', $a);
    $datosB = preg_split('/\s+/', $b);
    return ($datosA[8] < $datosB[8]) ? -1 : 1;
  } else if(substr($a, -1) != "/" && substr($b, -1) == "/"){
    return 1;
  } else {
    $datosA = preg_split('/\s+/', $a);
    $datosB = preg_split('/\s+/', $b);
    return ($datosA[8] < $datosB[8]) ? -1 : 1;
  }
}

uasort($contentsArray, 'cmp');
 
// *** Output our array of folder contents
//print_r($contentsArray);

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

?>
<table>
    <thead>
      	<tr>
            <th style="width: 1px"></th>
          	<th>Nombre</th>
          	<th>Tama&ntilde;o</th>
          	<th>&Uacute;ltima modificaci&oacute;n</th>
          	<th>Permisos</th>

      	</tr>
    </thead>
    <tbody>
  		<?php 
  		foreach($contentsArray as $archivo){
        $datos = preg_split('/\s+/', $archivo);
        if(!($datos[8] == "./") && !($datos[8] == "../" && $dir == "/")){
          $datos[8] = implode(" ", array_slice($datos, 8)); //Juntar las palabras que componen el nombre del archivo o carpeta
  			?>
  			<tr style="padding: 0px">
          <td><?php 
          if($datos[8] != "../"){ ?>
            <input type="checkbox" class="filled-in CBelemento" id="<?php echo $datos[8] ?>" />
            <label for="<?php echo $datos[8] ?>"></label>
          <?php
          }
          ?>
          </td>
  				<td>
  					<?php 
  						if(substr($datos[8], -1) == "/"){ //Si el objeto de la lista es una carpeta
  							echo '<a class="carpeta" id="' . $datos[8] . '"><i class="material-icons left gray-text text-darken-1 ">folder</i>'; 
  							echo $datos[8] . '</a>';
  						} else {
  							echo $datos[8];
  						}
  					?></td>
				  <td><?php echo human_filesize($datos[4]) ?></td>
          <td><?php echo $datos[5] . ' ' . $datos[6] . ' ' . $datos[7]?></td>
        	<td><?php echo $datos[0] ?></td>
    		</tr>
  			<?php
        }
		  }
  		?>
    </tbody>
</table>