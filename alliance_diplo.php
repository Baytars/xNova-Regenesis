<?php

/*Alliance_diplo.php by jtsamper
 CREATE TABLE `{präfix}_diplo` (
`pact_owner` VARCHAR( 500 ) NOT NULL ,
`pact_ally` VARCHAR( 500 ) NOT NULL ,
`type` INT( 1 ) NOT NULL ,
`accept` INT( 1 ) NOT NULL ,
`pact_ally_id` INT( 5 ) NOT NULL
) ENGINE = MYISAM 

(c) Copyright by jtsamper AND Project Xnova(www.new-xnova.es) | 1. Marzo 2009
*/

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

global $user;

$parse['ally_name'] = $user['ally_name'];
$parse['ally_id'] = $user['ally_id'];


for($i=1;$i<=3;$i++){
$n2=$i;
	if($n2==1){
	$mensajediplo="Alianza";
	$typen="1";
	}elseif($n2 ==2){
	$mensajediplo="No Agresion";
	$typen="2";
	}elseif($n2 ==3){
	$typen="3";
	$mensajediplo="Guerra";
	}
$parse['bnd'] .= "<tr><td class=c colspan=3><b><u><center>".$mensajediplo."</center></b></u></td>
</tr>";
$query = doquery("SELECT * FROM {{table}} WHERE `pact_ally_id` = '". $user['ally_id'] ."' AND `type` = '".$typen."' AND `accept` = '0'", "diplo");
	while ($u = mysql_fetch_array($query)) {
	if($u['pact_owner']!=$user['ally_id']){
	$origen2= $u['pact_owner'];
	}else{
	$origen2= $u['pact_ally_id'];
	}
$diplo2 = doquery("SELECT `ally_name` FROM {{table}} WHERE `id`= '". $origen2 ."'", "alliance",true);
$parse['bnd'] .= "<tr><td class=b colspan=3><center><b><font color=lime>" . $diplo2['ally_name'] . "</a></center></b></td></tr>";
	}
	$query1 = doquery("SELECT * FROM {{table}} WHERE `pact_owner` = '". $user['ally_id'] ."' AND `type` = '".$typen."' AND `accept` = '0'", "diplo");
while ($u = mysql_fetch_array($query1)) {
	if($u['pact_owner']!=$user['ally_id']){
	$origen2= $u['pact_owner'];
	}else{
	$origen2= $u['pact_ally_id'];
	}
$diplo2 = doquery("SELECT `ally_name` FROM {{table}} WHERE `id`= '". $origen2 ."'", "alliance",true);
$parse['bnd'] .= "<tr><td class=b colspan=3><center><b><font color=lime>" . $diplo2['ally_name'] . "</a></center></b></td></tr>";
	}
	
}
     if(isset($_POST['type']) && isset($_POST['ally'])) {
	   
	   if($_POST['type'] == "1") {//Alianza
	   $type = "1"; 
	   } elseif ($_POST['type'] == "2") {//No Agresion
	   $type = "2";
	   } elseif ($_POST['type'] == "3") {//Guerra
	   $type = "3";
	   } else {
	   AdminMessage ('<meta http-equiv="refresh" content="1; url=alliance_diplo.php">No a seleccionado tipo de pacto', 'Error');
       }
       $ally_id = doquery("SELECT `id` FROM {{table}} WHERE `ally_name` = '". $_POST['ally'] ."'", "alliance");  
       $id = mysql_fetch_array($ally_id);
	   
	   	doquery("INSERT INTO {{table}} SET
	`pact_owner` = '". $user['ally_id'] ."',
	`pact_ally` = '". $_POST['ally'] ."',
	`type` = '". $type ."',
	`accept` = '1',
	`pact_ally_id` = '". $id['id'] ."'", "diplo");
	
	if($type==1){
	$tipo="una alianza a ";
	}elseif($type==2){
	$tipo="un pacto de no agresion a ";
	}elseif($type==3){
	$tipo="una guerrar a ";
	}
		  AdminMessage ('<meta http-equiv="refresh" content="1; url=alliance_diplo.php">Acabas de proponer '.$tipo.$_POST['ally'], 'Erfolgreich');

}


       if(isset($_GET['add'])) {

  $ally = doquery("SELECT `id`,`ally_name` FROM {{table}}", "alliance");  
	$h = 0;
  while ($c = mysql_fetch_array($ally)) {
  $existente = doquery("SELECT `pact_ally_id`,`pact_owner` FROM {{table}} ", "diplo",true);  
 if($user['ally_id']!=$c['id']){
  if($c['id']!=$existente['pact_ally_id'] && $c['id']!=$existente['pact_owner'] ){
  
$parse['allys'] .= "<option>". $c['ally_name'] ."</option>";
}
}
	$h++;
}	   
	   
$page = parsetemplate(gettemplate('alliance_diplo_add'), $parse);
			display($page);
}
     
	 if(isset($_GET['anfragen'])) {

      $accept = doquery("SELECT `pact_ally`, `pact_owner`, `pact_ally_id`, `type` FROM {{table}} WHERE `pact_ally_id` = '". $user['ally_id'] ."' AND `accept` = '1'", "diplo");
	  
	$h = 0;
  while ($c = mysql_fetch_array($accept)) {
        $blub = doquery("SELECT `ally_name` FROM {{table}} WHERE `id` = '". $c['pact_owner'] ."'", "alliance");
 $blub = mysql_fetch_array($blub);
  if($c['type']==1){
  $new="Alianza";
  }elseif($c['type']==2){
    $new="No Agresion";
  }elseif($c['type']==3){
    $new="Guerra";
  }
$parse['accept'] .= "<tr><td class=b><b>". $blub['ally_name'] ."</b> [".$new."] <a href=alliance_diplo.php?accept=". $c['pact_ally_id'] ."><img src='img/ok.jpg' width='13' height='13' title='Aceptar'/></a>
<a href=alliance_diplo.php?denegar=". $c['pact_ally_id'] ."><img src='img/cerrar.gif' width='13' height='13' title='Negar'/></a></td></tr>";
	$h++;
	  }
	 
	   
$page = parsetemplate(gettemplate('alliance_diplo_anfragen'), $parse);
			display($page);
}
	  if(isset($_GET['accept'])) {
	  $accept = doquery("SELECT `pact_ally`, `pact_owner`, `pact_ally_id`, `type` FROM {{table}} WHERE `pact_ally_id` = '". $user['ally_id'] ."' AND `accept` = '1'", "diplo");
$c = mysql_fetch_array($accept);
	          $blub = doquery("SELECT `ally_name` FROM {{table}} WHERE `id` = '". $c['pact_owner'] ."'", "alliance");
 $blub = mysql_fetch_array($blub);
	doquery("UPDATE {{table}} SET `accept` = '0' WHERE `pact_ally_id` = '". $_GET['accept'] ."' AND `type` =". $c['type'] ."", "diplo");  
	AdminMessage ('<meta http-equiv="refresh" content="1; url=alliance_diplo.php">Acabas de aceptar el tratado', 'Anuncio');

	}
	if(isset($_GET['denegar'])) {
	  $accept = doquery("SELECT `pact_ally`, `pact_owner`, `pact_ally_id`, `type` FROM {{table}} WHERE `pact_ally_id` = '". $user['ally_id'] ."' AND `accept` = '1'", "diplo");
$c = mysql_fetch_array($accept);
	 $blub = doquery("SELECT `ally_name` FROM {{table}} WHERE `id` = '". $c['pact_owner'] ."'", "alliance");
 	$blub = mysql_fetch_array($blub);
	doquery("DELETE FROM {{table}} WHERE `pact_ally_id` = '". $_GET['denegar'] ."' AND `type` ='". $c['type'] ."'", "diplo");  
	AdminMessage ('<meta http-equiv="refresh" content="1; url=alliance_diplo.php">Acabas de denegar tratado', 'Anuncio');

	}
	
       $ally_id = doquery("SELECT `ally_owner` FROM {{table}} WHERE `id` = '". $user['ally_id'] ."'", "alliance");  
       $id = mysql_fetch_array($ally_id);

if($user['id'] == $id['ally_owner']) {
$parse['admin'] = "<tr>
  <td class=c colspan=3><b><u><center>Administrador</b></u></td>
</tr>
<tr>
  <td class=b colspan=1><b><a href=alliance_diplo.php?add=". $user['ally_id'] ."><center>Nueva Solicitud</a></td>
  <td class=b colspan=1><a href=alliance_diplo.php?anfragen=". $user['ally_id'] ."><center>Solicitudes</a></center></b></td>
</tr>";
} else {
$parse['admin'] = "";
}
			$page = parsetemplate(gettemplate('alliance_diplo'), $parse);
			display($page);
?>