#!/bin/bash 
# Constantes.
USUARIO=sacta
CONTRASENA="Sacta1"
DIR_FTP=/home/$USUARIO/ftp
DIR_ARCHIVOS=$DIR_FTP/archivos
TEXTO_PRUEBA="vsftpd Archivo de prueba."
RUTA_PRUEBA=$DIR_ARCHIVOS/prueba.txt
RUTA_CONF_VSFTPD=/etc/vsftpd.conf
RUTA_USUARIOS_PERMITIDOS=/etc/vsftpd.userlist

# Copiar configuracion original.
cp -n $RUTA_CONF_VSFTPD $RUTA_CONF_VSFTPD.orig

# Abrir puertos de muro de fuego.
ufw allow 20/tcp
ufw allow 21/tcp
ufw allow 990/tcp
ufw allow 40000:50000/tcp

# Agregar usuario.
useradd -p $(openssl passwd -1 $CONTRASENA) $USUARIO

# Crear directorio para archivos en FTP.
mkdir $DIR_FTP
chown nobody:nogroup $DIR_FTP
chmod a-w $DIR_FTP

# Crear directorio para archivos.
mkdir $DIR_ARCHIVOS
chown $USUARIO:$USUARIO $DIR_ARCHIVOS

# Crear archivo de prueba.
echo $TEXTO_PRUEBA | tee $RUTA_PRUEBA

# Reemplazar texto en archivo de configuracion.
# Permitir escritura a usuarios locales.
sed -i -e 's/# *local_enable=YES/local_enable=YES/g' $RUTA_CONF_VSFTPD
sed -i -e 's/# *write_enable=YES/write_enable=YES/g' $RUTA_CONF_VSFTPD
sed -i -e 's/# *chroot_local_user=YES/chroot_local_user=YES/g' $RUTA_CONF_VSFTPD

# Agregar usuario a ruta para permitir acceso.
echo -e "# Agregar usuario a ruta para permitir acceso." >> $RUTA_CONF_VSFTPD
echo -e "user_sub_token=$USER" >> $RUTA_CONF_VSFTPD
echo -e "local_root=$DIR_FTP" >> $RUTA_CONF_VSFTPD
echo -e "" >> $RUTA_CONF_VSFTPD

# Agregar lista de puertos pasivos.
echo -e "# Agregar lista de puertos pasivos." >> $RUTA_CONF_VSFTPD
echo -e "pasv_min_port=40000" >> $RUTA_CONF_VSFTPD
echo -e "pasv_min_port=50000" >> $RUTA_CONF_VSFTPD
echo -e "" >> $RUTA_CONF_VSFTPD

# Permitir usuarios acceso al servidor FTP cuando esten en la lista.
echo -e "# Permitir usuarios acceso al servidor FTP cuando esten en la lista." >> $RUTA_CONF_VSFTPD
echo -e "userlist_enable=YES" >> $RUTA_CONF_VSFTPD
echo -e "userlist_file=$RUTA_USUARIOS_PERMITIDOS" >> $RUTA_CONF_VSFTPD
echo -e "userlist_deny=NO" >> $RUTA_CONF_VSFTPD
echo -e "" >> $RUTA_CONF_VSFTPD

# Agregar usuario a la lista de usuarios permitidos.
echo "$USUARIO" | tee -a $RUTA_USUARIOS_PERMITIDOS

# Permitir acceso a ftp con el servicio de PAM.
echo -e "# Permitir acceso a ftp con el servicio de PAM." >> $RUTA_CONF_VSFTPD
echo -e "pam_service_name=ftp" >> $RUTA_CONF_VSFTPD
echo -e "" >> $RUTA_CONF_VSFTPD

# Reiniciar el servicio.
systemctl restart vsftpd
