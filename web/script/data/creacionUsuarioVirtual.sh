#!/bin/bash
# Archivo para crear un usuario virtual de ftp.

# Parametros: usuario contraseña

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# CONSTANTES.
USUARIO_FTP="vsftpd"
ARCHIVO_CONTRASENAS="/etc/vsftpd/ftpd.passwd"
DIRECTORIO_FTP_USUARIO="/home/$USUARIO_FTP/ftp"
DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES="/etc/vsftpd_user_conf"
NOMBRE_DIRECTORIO_COMPARTIDOS="compartidos"

# PRINCIPAL/MAIN.
# Definir credenciales y rutas de directorio y archivo de configuracion
# de usuario virtual.

# Usuario.
if [ -z "$1" ]; then
	echo "Ingrese nombre de usuario virtual: "
	read USUARIO_VIRTUAL
else
	USUARIO_VIRTUAL="$1"
fi

# Contraseña.
if [ -z "$2" ]; then
	echo "Ingrese contraseña de usuario virtual ($USUARIO_VIRTUAL): "
	read CONTRASENA_VIRTUAL
else
	CONTRASENA_VIRTUAL="$2"
fi

# Definir rutas de archivos y directorios a utilizar.
DIRECTORIO_VIRTUAL="$DIRECTORIO_FTP_USUARIO/$USUARIO_VIRTUAL"
ARCHIVO_VIRTUAL="$DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES/$USUARIO_VIRTUAL"

# Crear o modificar archivo para contraseñas.
if [ -f "$ARCHIVO_CONTRASENAS" ]
then
	htpasswd -p -b "$ARCHIVO_CONTRASENAS" "$USUARIO_VIRTUAL" $(openssl passwd -1 -noverify "$CONTRASENA_VIRTUAL")
else
	htpasswd -c -p -b "$ARCHIVO_CONTRASENAS" "$USUARIO_VIRTUAL" $(openssl passwd -1 -noverify "$CONTRASENA_VIRTUAL")
fi

# Crear directorio para usuario virtual junto con archivo con ruta a
# directorio de usuario virtual.
mkdir "$DIRECTORIO_VIRTUAL"

# Crear directorio de archivos compartidos.
mkdir "$DIRECTORIO_VIRTUAL/$NOMBRE_DIRECTORIO_COMPARTIDOS"

# Editar valores de ftp para usuario virtual.
echo "local_root=$DIRECTORIO_VIRTUAL" >> "$ARCHIVO_VIRTUAL"
echo "write_enable=YES" >> "$ARCHIVO_VIRTUAL"
echo "allow_writeable_chroot=YES" >> "$ARCHIVO_VIRTUAL"

# Dar posesion al usuario ftp.
chown -R "$USUARIO_FTP:nogroup" "$DIRECTORIO_VIRTUAL"

# Permitir escritura en directorio de usuario virtual.
chmod 757 -R "$DIRECTORIO_VIRTUAL"

# Reiniciar servicio de vsftpd.
service vsftpd restart
