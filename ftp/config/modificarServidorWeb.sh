#!/bin/bash 
# Archivo para modificar parametros del servidor web.
# Constantes.
USUARIO=sacta
CONTRASENA="Sacta1"
DIR_FTP=/home/$USUARIO/ftp
DIR_TEMP=$DIR_FTP/temp 

# Crear directorio para archivos temporales.
mkdir $DIR_TEMP

# Permitir que cualquier usuario escriba archivos en el folder temporal.
chmod 777 -R $DIR_TEMP/
