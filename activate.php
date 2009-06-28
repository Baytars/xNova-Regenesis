<?php

/**
* activate.php
*
* @version 1.0
* @copyright 2008 por NeuruS for ZaGamex
*/


define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc'); 
include($ugamela_root_path . 'common.' . $phpEx);

includeLang('activate');


$activate_hash = mysql_escape_string($_GET['hash']);
$activate_stamp = mysql_escape_string($_GET['stamp']);
$activate_mode = mysql_escape_string($_GET['mode']);
$stamp = base64_decode($activate_stamp);
$hash = base64_decode($activate_hash);
$Message = "Error";

if ($_GET['hash'] = ''){
      message( $lang['hash_error'], $Message);
}

if ($_GET['stamp'] = '') {
      message( $lang['stamp_error'], $Message);
   }
if ($_GET['mode'] = '') {
      message( $lang['mode_error'], $Message);
   }
if ($activate_mode == "options"){

$tblatudp = doquery("UPDATE {{table}} SET `activate_status` = '1' WHERE upper(`username`) = upper('" . $hash . "') AND `id` = '" . $stamp . "' LIMIT 1;",'users');
}else{

$tblatudp = doquery("UPDATE {{table}} SET `activate_status` = '1' WHERE  upper(`username`) = upper('" . $hash . "') AND `id` = '" . $stamp . "' LIMIT 1;",'users');
}



   if ($tblatudp) {
   
      message( $lang['tblatudp_true'], "Información");
      }
      
?>