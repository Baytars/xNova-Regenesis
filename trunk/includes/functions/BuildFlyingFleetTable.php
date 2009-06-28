<?php

/**
 * BuildFlyingFleetTable.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

function BuildFlyingFleetTable () {
	global $lang;

	$TableTPL     = gettemplate('admin/fleet_rows');
	$FlyingFleets = doquery ("SELECT f.*, uc.username as username1 ,ut.username as username2 FROM {{table}}fleets as f,{{table}}users as uc,{{table}}users as ut where (uc.id=f.fleet_owner AND ut.id=f.fleet_target_owner) OR (ut.id=f.fleet_owner AND uc.id=f.fleet_target_owner) ORDER BY f.fleet_end_time ASC;", '');
$i=0;
	while ( $CurrentFleet = mysql_fetch_assoc( $FlyingFleets ) ) {
		$Bloc['Id']       = $CurrentFleet['fleet_id'];
		$Bloc['Mission']  = CreateFleetPopupedMissionLink ( $CurrentFleet, $lang['type_mission'][ $CurrentFleet['fleet_mission'] ], '' );
		$Bloc['Mission'] .= "<br>". (($CurrentFleet['fleet_mess'] == 1) ? "R" : "A" );

		$Bloc['Fleet']    = CreateFleetPopupedFleetLink ( $CurrentFleet, $lang['tech'][200], '' );
		$Bloc['St_Owner'] = "[". $CurrentFleet['fleet_owner'] ."]<br>". $CurrentFleet['username1'];
		$Bloc['St_Posit'] = "[".$CurrentFleet['fleet_start_galaxy'] .":". $CurrentFleet['fleet_start_system'] .":". $CurrentFleet['fleet_start_planet'] ."]<br>". ( ($CurrentFleet['fleet_start_type'] == 1) ? "[P]": (($CurrentFleet['fleet_start_type'] == 2) ? "D" : "L"  )) ."";
		$Bloc['St_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_start_time']);
		if (is_array($CurrentFleet)) {
			$Bloc['En_Owner'] = "[". $CurrentFleet['fleet_target_owner'] ."]<br>". $CurrentFleet['username2'];
		} else {
			$Bloc['En_Owner'] = "";
		}
		$Bloc['En_Posit'] = "[".$CurrentFleet['fleet_end_galaxy'] .":". $CurrentFleet['fleet_end_system'] .":". $CurrentFleet['fleet_end_planet'] ."]<br>". ( ($CurrentFleet['fleet_end_type'] == 1) ? "[P]": (($CurrentFleet['fleet_end_type'] == 2) ? "D" : "L"  )) ."";
		if ($CurrentFleet['fleet_mission'] == 15) {
			$Bloc['Wa_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_stay_time']);
		} else {
			$Bloc['Wa_Time']  = "";
		}
		$Bloc['En_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_end_time']);

	$i++;
		$table['flt_table'] .= parsetemplate( $TableTPL, $Bloc );
	}
		$table['num']=$i;
	return $table;
}


?>