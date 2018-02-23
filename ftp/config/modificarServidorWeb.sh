#!/bin/bash 
# Archivo para modificar parametros del servidor web.

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# Constantes.
USUARIO="vsftpd"
DIR_FTP="/home/$USUARIO/ftp"
DIR_TEMP="$DIR_FTP/temp"
DIR_WEB="$(cd $(pwd)/../../web; pwd)"
DIR_SITIO_WEB="/var/www/html/sactaftp"

# Crear directorio de ftp (si aun no esta creado).
mkdir $DIR_FTP

# Crear directorio para archivos temporales.
mkdir $DIR_TEMP

# Permitir que cualquier usuario escriba archivos en el folder temporal.
chmod 777 -R $DIR_TEMP/

# Crear vinculo simbolico a folder de web.
ln -s $DIR_WEB $DIR_SITIO_WEB
