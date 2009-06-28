<?php

/**
 * Baneos.php
 *
 * @version 1
 * @copyright 2008 By jtsamper for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
includeLang('admin');
includeLang('admin/banned');
$mode=$_GET["banear"];

switch ($mode){
case 'ban':
      if ($user['authlevel'] >= 1) {
		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/banned");

		$parse     = $lang;

		if ($mode == 'banit') {
		$name              = $_POST['name'];
		$reas              = $_POST['why'];
		$Now               = time();
		$days              = $_POST['days'];
			$hour              = $_POST['hour'];
			$mins              = $_POST['mins'];
			$secs              = $_POST['secs'];
switch ($reas){
case 'otro':


			$BanTime           = $days * 86400;
			$BanTime          += $hour * 3600;
			$BanTime          += $mins * 60;
			$BanTime          += $secs;
			$BannedUntil       = $Now + $BanTime;
break;
case 'multicuenta':
$BanTime           = 5 * 86400;
$BannedUntil       = $Now + $BanTime;
break;
case 'insultar':
$BanTime           = 7 * 86400;
$BannedUntil       = $Now + $BanTime;
break;
case 'intercambio':
$BanTime           = 4 * 86400;
$BannedUntil       = $Now + $BanTime;
break;
case 'amenazas':
$BanTime           = 30 * 86400;
$BannedUntil       = $Now + $BanTime;
break;
case 'bugUsing':
$BanTime           = 15 * 86400;
$BannedUntil       = $Now + $BanTime;
break;
case ('pushing'||'bashing'):
$BanTime           = 6 * 86400;
$BannedUntil       = $Now + $BanTime;
break;
}
			$admin             = $user['username'];
			$mail              = $user['email'];
if($reas=="mastiempo"){
			$BanTime           = $days * 86400;
			$BanTime          += $hour * 3600;
			$BanTime          += $mins * 60;
			$BanTime          += $secs;

$bantiemp= doquery("SELECT * FROM {{table}} where `who` = '".$name."'",'banned', true);
			$BannedUntil= $bantiemp['longer']+$BanTime;

			$QryInsertBan      = "UPDATE {{table}} SET ";
			$QryInsertBan     .= "`longer` = '". $BannedUntil ."' ";
			$QryInsertBan     .= "WHERE ";
			$QryInsertBan     .= "`who` = '".$name."'";
			doquery( $QryInsertBan, 'banned');
}else{
			$QryInsertBan      = "INSERT INTO {{table}} SET ";
			$QryInsertBan     .= "`who` = \"". $name ."\", ";
			$QryInsertBan     .= "`theme` = '". $reas ."', ";
			$QryInsertBan     .= "`who2` = '". $name ."', ";
			$QryInsertBan     .= "`time` = '". $Now ."', ";
			$QryInsertBan     .= "`longer` = '". $BannedUntil ."', ";
			$QryInsertBan     .= "`author` = '". $admin ."', ";
			$QryInsertBan     .= "`email` = '". $mail ."';";
doquery( $QryInsertBan, 'banned');
			$QryUpdateUser     = "UPDATE {{table}} SET ";
			$QryUpdateUser    .= "`bana` = '1', ";
			$QryUpdateUser    .= "`banaday` = '". $BannedUntil ."' ";
			$QryUpdateUser    .= "WHERE ";
			$QryUpdateUser    .= "`username` = \"". $name ."\";";
			doquery( $QryUpdateUser, 'users');
}




			$DoneMessage       = $lang['adm_bn_thpl'] ." ". $name ." ". $lang['adm_bn_isbn'];
			AdminMessage ($DoneMessage, $lang['adm_bn_ttle']);
		}
		$parse['ban']=$_GET['user'];
		$Page = parsetemplate($PageTpl, $parse);
		display( $Page, $lang['adm_bn_ttle'], false, '', true);
	} else {
		AdminMessage ($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
        break;
case 'desban':
if ($user['authlevel'] >= "2") {

		$parse['dpath'] = $dpath;
		$parse = $lang;

		$mode = $_GET['mode'];

		if ($mode != 'change') {
			$parse['Name'] = "Nombre del jugador";
			$baned = doquery("Select * From {{table}} ;", 'banned');

			$parse['baneados'] = '<select name="nam">';
			while($ba =  mysql_fetch_array($baned)){
						$parse['baneados'] .= "<option value=".$ba['who2'].">".$ba['who2']."</option>";
						}
			$parse['baneados'] .= '</select>';
		} elseif ($mode == 'change') {
			$nam = $_POST['nam'];
			doquery("DELETE FROM {{table}} WHERE who2='{$nam}'", 'banned');
			doquery("UPDATE {{table}} SET bana=0, banaday=0 WHERE username='{$nam}'", "users");
			message("Le joueur {$nam} a bien &eacute;t&eacute; d&eacute;banni!", 'Information');
		}

		display(parsetemplate(gettemplate('admin/unbanned'), $parse), "Overview", false, '', true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
break;
case 'ip':


if ($user['authlevel'] >= 2) {
$lang['agregar']= "baneos.php?banear=ip&x=add";
	if ($_GET['x'] == 'add') {
// si agregamos una direccion mostraremos el formulario
// y en caso de que el formulario haya sido enviado crearemos el registro
		if ($_POST['add']){

			$ip = $_POST['ip'];
			if (!$ip){
				message($lang['add_no_ip'], $lang['error']);
			}
			addban($ip,$_POST['reason'],$_POST['legnth']);

		}else{
		// otra manera de mostrar el formulario
		$page1 .= parsetemplate(gettemplate('admin/bannedipform'), $lang);
		display($page1, $lang['ip_ban_sys'], false, '', true );
		}
	}
// eliminar una direccion
	if ($_GET['x'] == 'delete') {
		if ($_GET['id']){
			delban($_GET['id']);
		}else{
		// show error
		message($lang['rem_no_ip'], $lang['error']);
		}
	}
	//sección principal
	$listbanned = doquery("SELECT * FROM {{table}}", 'bannedip');
	$i = 0;
	$banned_list = '';
	while ($r = mysql_fetch_array($listbanned)){
		$i++;
		$r['i'] = $i;
		$r['razon'] = $r['reason'];
		$r['borrar'] = "<a href=\"./baneos.php?banear=".$mode."&x=delete&id={$r[id]}\">Eliminar</a>";
		$banned_list .= parsetemplate(gettemplate('admin/bannedip_row'), $r);
	}
	$lang['lista'] = $banned_list;
	$page .= parsetemplate(gettemplate('admin/bannedip'), $lang);
	display($page, $lang['ip_ban_sys'], false, '', true );
}else{
message($lang['no_admin'], $lang['error']);
}
break;
case '':
$lang['ban']="baneos.php?banear=ban";
$lang['desban']="baneos.php?banear=desban";
$lang['ip']="baneos.php?banear=ip";
display(parsetemplate(gettemplate('admin/baneo'), $lang),'', false, '', true );
break;
}
?>
