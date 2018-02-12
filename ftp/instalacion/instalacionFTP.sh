#!/bin/bash
# Archivo para instalacion de servidor LAMP y servidor FTP (con vsftpd).
# Uso para Debian y distribuciones basadas en Debian (hecho con uso preferido
# para Linux Mint).

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# Actualizar lista de paquetes.
apt-get update

# Instalar **servidor LAMP**.
apt-get install lamp-server^

# Instalar paquetes con uso de **vsftpd**.
apt-get install vsftpd*
