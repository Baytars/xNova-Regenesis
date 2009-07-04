<?php
$lang['adm_clean_title']		= 'Limpiador de bugs de las tablas de usuario,planetas y galaxias';
$lang['adm_clean_explain']		= 'Este script genera 2 tipos de comprobaciones a las tablas y en base a esos resultados determina el tipo de limpieza que debe hacer.<br> Los tipos de limpieza posible son:<br>-1 Limpieza inteligente<br>-2 Limpieza por fuerza bruta<br> Si tus tablas requieren solo limpieza inteligente el consumo de memoria y tiempo de ejecuci&oacute;n del script ser&aacute;n bajos, en cambio si requiere limpieza por fuerza bruta este consumo y este tiempo ser&aacute;n mayores y se puede frenar el script dependiendo del servidor. Si este ocurre tu base de datos puede arruinarse (o tener mas problemas que antes).<br>Antes de usar este script es preferible que hagas un respaldo de tu base de datos.<br><br>Est&aacute;s seguro de que quieres limpiar de bugs el sistema?'; 
$lang['adm_clean']				= 'Limpiar';
$lang['adm_deleted_users']		= 'Fueron eliminados: %u usuarios<br> Los id de los usuarios eliminados son:<br>%iu<br>';
$lang['adm_deleted_planets']	= 'Fueron eliminados: %p planetas<br> Los id de los planetas eliminados son:<br> %ip<br>';
$lang['adm_deleted_galaxy']		= 'Fueron eliminados: %g posiciones de galaxia<br> Las posiciones de galaxia eliminadas son:<br> %ig<br>';
$lang['adm_time'] = 'Tiempo total de ejecuci&oacute;n: %ti<br>';
$lang['adm_i_mem'] = 'memoria al inicio de la ejecuci&oacute;n: %mi/%mti<br>';
$lang['adm_e_mem'] = 'memoria al final de la ejecuci&oacute;n: %me/%mte<br>';
$lang['adm_succes'] = 'El proceso finalizo correctamente<br>';
$lang['adm_del_title'] ='Eliminacion de id no usados';
?>