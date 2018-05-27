#!/bin/bash
# Archivo para clonacion e instalacion completa de repositorio/proyecto.
# Uso para Debian y distribuciones basadas en Debian (hecho con uso preferido
# para Linux Mint).

# Verificar si usuario es super usuario. Si no salir.
if [ "$EUID" -ne 0 ]
	then echo "Por favor correr como superusuario (sudo)."
	exit
fi

# Actualizar lista de paquetes.
apt-get update

# Instalar paquetes necesarios para instalacion, desarrollo y modificacion de
# sitio web.
apt-get install -y git vim ssh

# Clonar repositorio en directorio actual.
git clone https://github.com/milkdoes/sactaFTP.git && sudo bash sactaFTP/script/instalacionCompleta.sh
