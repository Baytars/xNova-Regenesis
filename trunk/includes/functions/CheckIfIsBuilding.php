<?php
/*
#############################################################################
#  Filename: CheckIfIsBuilding.php
#  Project: prethOgame
#  Description: RPG web based game
#
#  Copyright © 2008 Aleksandar Spasojevic <spalekg@gmail.com>
#  Copyright © 2005 - 2008 KGsystem
#############################################################################
*/
function CheckIfIsBuilding($CurrentUser){
  $fleets = doquery("SELECT `fleet_owner` FROM {{table}} WHERE `fleet_owner` = '".$CurrentUser."'", 'fleets',true);
	$error=0;
   if($fleets){
     $error++;
	 //$erro.="flota";
   }

$vaca = doquery("SELECT `b_building`,`b_tech`,`b_hangar` FROM {{table}} WHERE id_owner = '".$CurrentUser."';", 'planets',true);
	  if($vaca['b_building'] != 0) {
			if($vaca['b_building'] != ""){
			$error++;
			//$erro.="build";
			}
		 }
	  if($vaca['b_tech'] != 0){
	 	 	if($vaca['b_tech'] != ""){         
           	$error++;
		    //$erro.="tech";
     	 	}
	  }
	  if($vaca['b_hangar'] != 0){
	  		if($vaca['b_hangar'] != ""){
            $error++;
			//$erro.="hangar";
			}
      }
unset($fleet,$vaca);
if($error!=0){
return TRUE;
}else{
return FALSE;
}
}
?>