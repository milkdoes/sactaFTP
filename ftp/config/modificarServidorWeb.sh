#!/bin/bash 
# Archivo para modificar parametros del servidor web.

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# Constantes.
USUARIO=sacta
CONTRASENA="Sacta1"
DIR_FTP=/home/$USUARIO/ftp
DIR_TEMP=$DIR_FTP/temp 

# Crear directorio para archivos temporales.
mkdir $DIR_TEMP

# Permitir que cualquier usuario escriba archivos en el folder temporal.
chmod 777 -R $DIR_TEMP/
