#!/bin/bash
# Archivo para configurar usuarios virtuales junto con sus directorios propios.

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# CONSTANTES.
USUARIO="vsftpd"
DIRECTORIO_FTP_USUARIO="/home/$USUARIO/ftp"
DIRECTORIO_VSFTPD="/etc/vsftpd"
DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES="/etc/vsftpd_user_conf"
ARCHIVO_VSFTPD="/etc/vsftpd.conf"
ARCHIVO_USUARIOS_VIRTUALES="textoUsuariosVirtuales.txt"
ARCHIVO_PAM_VIEJO="/etc/pam.d/vsftpd"
ARCHIVO_PAM_NUEVO="textoPamVsftpd.txt"
# Credenciales de usuario ejemplo.
USUARIO_EJEMPLO="user1"
CONTRASENA_EJEMPLO="user1"
DIRECTORIO_EJEMPLO="$DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES/$USUARIO_EJEMPLO"

# PRINCIPAL/MAIN.
# Agregar configuracion de usuarios virtuales.
cat $ARCHIVO_USUARIOS_VIRTUALES >> $ARCHIVO_VSFTPD

# Crear directorio de configuracion.
mkdir $DIRECTORIO_VSFTPD

# Crear archivo para contraseñas.
htpasswd -c -p -b /etc/vsftpd/ftpd.passwd $USUARIO_EJEMPLO $(openssl passwd -1 -noverify $CONTRASENA_EJEMPLO)

# Sobreborrar archivo de pam.
cat $ARCHIVO_PAM_NUEVO > $ARCHIVO_PAM_VIEJO

# Crear usuario local para que usuarios virtuales puedan acceder.
useradd --home /home/$USUARIO --gid nogroup -m --shell /bin/false $USUARIO

# Crear folder por defecto en donde poner archivos.
mkdir $DIRECTORIO_FTP_USUARIO

# Crear folder de configuracion de usuarios.
mkdir $DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES

# Crear directorio ejemplo para usuario ejemplo junto con archivo con ruta a
# directorio ejemplo.
mkdir $DIRECTORIO_EJEMPLO
echo "local_root=$DIRECTORIO_EJEMPLO" >> "$DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES/$USUARIO_EJEMPLO"

# Cambiar derechos de escritura a directorio de usuario local para usuario virtuales.
chown $USUARIO:nogroup $DIRECTORIO_EJEMPLO

# Reiniciar servicio de vsftpd.
service vsftpd restart
