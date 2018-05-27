#!/bin/bash
# Archivo para correr todos los scripts necesarios para montar el proyecto.
# Uso para Debian y distribuciones basadas en Debian (hecho con uso preferido
# para Linux Mint).

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# Correr todos los archivos en secuencia.
bash ../ftp/instalacionFTP.sh
cd ../ftp/config/
bash configurarUsuariosVirtuales.sh
bash modificarServidorWeb.sh
