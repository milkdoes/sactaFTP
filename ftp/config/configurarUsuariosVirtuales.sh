#!/bin/bash
# Archivo para configurar usuarios virtuales junto con sus directorios propios.

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# FUNCIONES.
# Reemplazar texto en un archivo si existe. Si no, agregarlo al final.
ReemplazarAgregarTexto() {
	local textoReemplazar=$1
	local textoNuevo=$2
	local archivo=$3

	grep -q "$textoReemplazar" $archivo && sed -i "s/$textoReemplazar/$textoNuevo/" $archivo || echo "$textoNuevo" >> $archivo
}

# CONSTANTES.
USUARIO=sacta
CONTRASENA="Sacta1" 
ARCHIVO_VSFTPD="/etc/vsftpd.conf"


# PRINCIPAL/MAIN.
# Configurar para correr como "Standalone".
STANDALONE_VIEJO=" *#* *listen=\(YES\|NO\).*"
STANDALONE_NUEVO="listen=YES"
ReemplazarAgregarTexto "$STANDALONE_VIEJO" "$STANDALONE_NUEVO" "$ARCHIVO_VSFTPD"
