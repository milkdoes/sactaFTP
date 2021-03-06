#!/bin/bash
# Archivo para modificar parametros del servidor web.

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# Constantes.
USUARIO="vsftpd"
USUARIO_WEB="www-data"
DIR_FTP="/home/$USUARIO/ftp"
DIR_TEMP="$DIR_FTP/temp"
DIR_WEB="$(cd $(pwd)/../../web; pwd)"
DIR_SITIO_WEB="/var/www/html/sactaftp"
ARCHIVO_SUDOERS="/etc/sudoers"

# Crear directorio de ftp (si aun no esta creado).
mkdir $DIR_FTP

# Crear directorio para archivos temporales.
mkdir $DIR_TEMP

# Permitir que cualquier usuario escriba archivos en el folder temporal.
chmod 777 -R $DIR_TEMP/

# Crear vinculo simbolico a folder de web si aun no existe.
if [ ! -e "$DIR_SITIO_WEB" ]
then
	ln -s $DIR_WEB $DIR_SITIO_WEB
fi

# Editar el archivo de sudoers para permitir uso de scripts desde pagina web.
TEXTO_USUARIO_TTY="Defaults:$USUARIO !requiretty"
grep -q -F "$TEXTO_USUARIO_TTY" "$ARCHIVO_SUDOERS" || echo -e "$TEXTO_USUARIO_TTY" >> "$ARCHIVO_SUDOERS"
TEXTO_USUARIO_WEB_TTY="Defaults:$USUARIO_WEB !requiretty"
grep -q -F "$TEXTO_USUARIO_WEB_TTY" "$ARCHIVO_SUDOERS" || echo -e "$TEXTO_USUARIO_WEB_TTY" >> "$ARCHIVO_SUDOERS"
TEXTO_PERMISOS_USUARIO_WEB="$USUARIO_WEB ALL=(ALL) NOPASSWD: ALL"
grep -q -F "$TEXTO_PERMISOS_USUARIO_WEB" "$ARCHIVO_SUDOERS" || echo -e "$TEXTO_PERMISOS_USUARIO_WEB" >> "$ARCHIVO_SUDOERS"

# Editar los archivos de php.ini para incrementar el tamaño maximo de archivos
# a subir.
textoArchivosPhpIni="$(locate -r 'php.ini$')"
for rutaArchivo in $textoArchivosPhpIni; do
	# Eliminar bytes de nueva a linea a ruta.
	nuevaRuta=${rutaArchivo//$'\n'/}

	# Respaldar archivo en caso de cambio fallido/no deseado.
	cp -n "$nuevaRuta" "$nuevaRuta.bak"

	# Cambiar valores de variables.
	sed -i -e 's/;\? *upload_max_filesize.*/upload_max_filesize = 25M/g' "$nuevaRuta"
	sed -i -e 's/;\? *post_max_size.*/post_max_size = 25M/g' "$nuevaRuta"
done

# Reiniciar el servicio de apache.
service apache2 stop
service apache2 start
