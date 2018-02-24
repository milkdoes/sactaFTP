#!/bin/bash
# Archivo para crear un usuario virtual de ftp.

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# CONSTANTES.
USUARIO_FTP="vsftpd"
DIRECTORIO_FTP_USUARIO="/home/$USUARIO_FTP/ftp"
DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES="/etc/vsftpd_user_conf"

# PRINCIPAL/MAIN.
# Definir credenciales y rutas de directorio y archivo de configuracion
# de usuario virtual.
echo "Ingrese nombre de usuario virtual: "
read USUARIO_VIRTUAL
echo "Ingrese contraseña de usuario virtual ($USUARIO_VIRTUAL): "
read CONTRASENA_VIRTUAL
DIRECTORIO_VIRTUAL="$DIRECTORIO_FTP_USUARIO/$USUARIO_VIRTUAL"
ARCHIVO_VIRTUAL="$DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES/$USUARIO_VIRTUAL"

# Crear o modificar archivo para contraseñas.
htpasswd -p -b /etc/vsftpd/ftpd.passwd "$USUARIO_VIRTUAL" $(openssl passwd -1 -noverify "$CONTRASENA_VIRTUAL")

# Crear directorio ejemplo para usuario ejemplo junto con archivo con ruta a
# directorio ejemplo.
mkdir "$DIRECTORIO_VIRTUAL"
echo "local_root=$DIRECTORIO_VIRTUAL" >> "$ARCHIVO_VIRTUAL"
echo "write_enable=YES" >> "$ARCHIVO_VIRTUAL"
echo "allow_writeable_chroot=YES" >> "$ARCHIVO_VIRTUAL"

# Permitir escritura en directorio de usuario ejemplo.
chmod 757 -R "$DIRECTORIO_VIRTUAL"

# Reiniciar servicio de vsftpd.
service vsftpd restart
