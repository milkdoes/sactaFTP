#!/bin/bash
# Archivo para compartir directorios y/o archivos a otro usuario.

# Parametros: usuarioHuesped usuarioPatrocinador rutaArchivoDirectorio1 rutaArchivoDirectorio2 .. rutaArchivoDirectorioN

# CONSTANTES.
USUARIO_FTP="vsftpd"
DIRECTORIO_FTP_USUARIO="/home/$USUARIO_FTP/ftp"
NOMBRE_DIRECTORIO_COMPARTIDOS="compartidos"

# Usuario patrocinador de archivos.
usuarioPatrocinador="$1"
# Usuario al cual compartir archivos.
usuarioHuesped="$2"

# Definir todos los archivos y directorios a compartir.
declare -a rutas=()
numeroArgumento=2
for textoRuta in "${@:3}"
do
	rutas+="$textoRuta"
done

# Crear directorio de compartimiento a huesped si no lo tiene.
directorioHuespedCompartidos="$DIRECTORIO_FTP_USUARIO/$usuarioHuesped/$NOMBRE_DIRECTORIO_COMPARTIDOS"
mkdir "$directorioHuespedCompartidos"
chown -R "$USUARIO_FTP:nogroup" "$directorioHuespedCompartidos"
chmod -R 757 "$directorioHuespedCompartidos"

directorioHuespedPatrocinador="$directorioHuespedCompartidos/$usuarioPatrocinador"
mkdir "$directorioHuespedPatrocinador"
chown -R "$USUARIO_FTP:nogroup" "$directorioHuespedPatrocinador"
chmod -R 757 "$directorioHuespedPatrocinador"

# Compartir los archivos y/o directorios dados.
rutaUsuarioPatrocinadorFtp="$DIRECTORIO_FTP_USUARIO/$usuarioPatrocinador"
for ruta in "$rutas"
do
	rutaActual="$rutaUsuarioPatrocinadorFtp/$ruta"
	rutaNueva="$directorioHuespedPatrocinador/$ruta"

	# Crear vinculo fuerte si es un archivo valido.
	if [ -f "$rutaActual" ]
	then
		cp -aln "$rutaActual" "$directorioHuespedPatrocinador"
	fi

	# Crear vinculo fuerte a cada archivo del directorio si es un directorio.
	if [ -d "$rutaActual" ]
	then
		cp -aln "$rutaActual" "$directorioHuespedPatrocinador"
	fi
done
