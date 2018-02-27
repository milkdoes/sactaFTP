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
DIRECTORIO_PUBLICO="$DIRECTORIO_FTP_USUARIO/public"
DIRECTORIO_VSFTPD="/etc/vsftpd"
DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES="/etc/vsftpd_user_conf"
ARCHIVO_VSFTPD="/etc/vsftpd.conf"
ARCHIVO_CONTRASENAS="/etc/vsftpd/ftpd.passwd"
ARCHIVO_USUARIOS_VIRTUALES="textoUsuariosVirtuales.txt"
ARCHIVO_PAM_VIEJO="/etc/pam.d/vsftpd"
ARCHIVO_PAM_NUEVO="textoPamVsftpd.txt"
# Credenciales de usuario ejemplo.
USUARIO_EJEMPLO="user1"
CONTRASENA_EJEMPLO="user1"
DIRECTORIO_EJEMPLO="$DIRECTORIO_FTP_USUARIO/$USUARIO_EJEMPLO"
ARCHIVO_EJEMPLO="$DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES/$USUARIO_EJEMPLO"

# PRINCIPAL/MAIN.
# Agregar configuracion de usuarios virtuales.
cat "$ARCHIVO_USUARIOS_VIRTUALES" >> "$ARCHIVO_VSFTPD"

# Crear directorio de configuracion.
mkdir "$DIRECTORIO_VSFTPD"

# Crear o modificar archivo para contraseñas.
if [ -f "$ARCHIVO_CONTRASENAS" ]
then
	htpasswd -p -b "$ARCHIVO_CONTRASENAS" "$USUARIO_VIRTUAL" $(openssl passwd -1 -noverify "$CONTRASENA_VIRTUAL")
else
	htpasswd -c -p -b "$ARCHIVO_CONTRASENAS" "$USUARIO_VIRTUAL" $(openssl passwd -1 -noverify "$CONTRASENA_VIRTUAL")
fi

# Sobreborrar archivo de pam.
cat "$ARCHIVO_PAM_NUEVO" > "$ARCHIVO_PAM_VIEJO"

# Crear usuario local para que usuarios virtuales puedan acceder.
useradd --home "/home/$USUARIO" --gid nogroup -m --shell /bin/false "$USUARIO"

# Crear folder por defecto en donde poner archivos.
mkdir "$DIRECTORIO_FTP_USUARIO"
mkdir "$DIRECTORIO_PUBLICO"

# Crear folder de configuracion de usuarios virtuales.
mkdir "$DIRECTORIO_CONFIGURACION_USUARIOS_VIRTUALES"

# Crear directorio ejemplo para usuario ejemplo junto con archivo con ruta a
# directorio ejemplo.
mkdir "$DIRECTORIO_EJEMPLO"
echo "local_root=$DIRECTORIO_EJEMPLO" >> "$ARCHIVO_EJEMPLO"
echo "write_enable=YES" >> "$ARCHIVO_EJEMPLO"
echo "allow_writeable_chroot=YES" >> "$ARCHIVO_EJEMPLO"

# Permitir escritura en directorio de usuario ejemplo.
chmod 757 -R "$DIRECTORIO_EJEMPLO"

# Reiniciar servicio de vsftpd.
service vsftpd restart
