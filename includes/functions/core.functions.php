<?php
//-----------------------------------
// CORE FUNCTIONS BY Pada
// USE AT YOUR OWN RISK :3
//-----------------------------------
function MakeEvents(){
	global $user, $game_config, $ugamela_root_path, $phpEx;
	
	// USERS UPDATING UNIVERSE?
	// I DONT RECOMMEND TO MODIFY, BUT, AS U WISH
	$UsersCheckingLimit = 2;
	$now = time();
	
	// GET THE CURRENT USERS UPDATING UNIVERSE
	if($game_config['users_checking']){
		$users_array = unserialize($game_config['users_checking']);
	}else{
		$users_array = array();
	}
	
	// CONFIG EXISTS?
	if(!$game_config['updatingfleet']){
		setConfigToValue("updatingfleet", 0);
		$game_config['updatingfleet'] = 0;
	}
	
	$UserInList = inArray($users_array, $user['id']);
	if(count($users_array) < $UsersCheckingLimit) $UserInList = true;
	
	unset($users_array);
	
	$OnlineUsers = doquery("SELECT id FROM {{table}} WHERE onlinetime >= '" . ( $now - 2 ) . "' ORDER BY id LIMIT " . $UsersCheckingLimit . ";", 'users');
	while($User = mysql_fetch_array($OnlineUsers)){
		$users_array[] = $User['id'];
	}
	//$users_array = array_unique($users_array);
	if (is_array($users_array)) { $users_array = array_unique($users_array);}
	$users_checking = serialize($users_array);
	
	
	if(($game_config['updatingfleet'] < $now) AND $UserInList){
	
		setConfigToValue("users_checking", $users_checking);
		setConfigToValue("updatingfleet", $now);
		
		$_fleets = doquery("SELECT * FROM {{table}} WHERE (`fleet_start_time` < '" . time() . "') OR (`fleet_end_time` < '" .time(). "')", 'fleets'); //  OR fleet_end_time <= ".time()
	//	doquery("LOCK TABLE {{table}}rw WRITE, {{table}}errors WRITE, {{table}}messages WRITE, {{table}}fleets WRITE, {{table}}planets WRITE, {{table}}galaxy WRITE ,{{table}}users WRITE,{{table}}planets as p1 WRITE,{{table}}planets as p2 WRITE","");
		while ($row = mysql_fetch_array($_fleets)) {

				/*$array                = array();
				$array['galaxy']      = $row['fleet_start_galaxy'];
				$array['system']      = $row['fleet_start_system'];
				$array['planet']      = $row['fleet_start_planet'];
				$array['planet_type'] = $row['fleet_start_type'];
		*/
				$temp = FlyingFleetHandler ($row);
				
		}
		//doquery("UNLOCK TABLES", "");
	/*	

		$_fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_end_time` < '" .time(). "';", 'fleets'); //  OR fleet_end_time <= ".time()
		while ($row = mysql_fetch_array($_fleets)) {
				$array                = array();
				$array['galaxy']      = $row['fleet_end_galaxy'];
				$array['system']      = $row['fleet_end_system'];
				$array['planet']      = $row['fleet_end_planet'];
				$array['planet_type'] = $row['fleet_end_type'];
		
				$temp = FlyingFleetHandler ($row);
		}
		*/
		unset($_fleets);
		
		//include($ugamela_root_path . 'rak.'.$phpEx);
	}
	
	// RESET USERS CHECKING UNIVERSE
	if(!$game_config['last_checkuser']){
		setConfigToValue("last_checkuser", $now);
	}else{
		if($game_config['last_checkuser'] < strtotime("-20 seconds", $now)){
			setConfigToValue("users_checking", "");
			setConfigToValue("last_checkuser", $now);
		}
	}
}

function setConfigToValue($config, $value){
global $game_config;
	if(!$config){
	 return false;
	}
/*	$Exists = doquery("SELECT config_name FROM {{table}} WHERE `config_name` = '" . $config . "' LIMIT 1;", "config", true);
	if(!$Exists){
	 doquery("INSERT INTO {{table}} SET `config_name` = '" . $config . "';", "config");
	}*/
	doquery("UPDATE {{table}} SET `config_value` = '" . $value . "' WHERE `config_name` = '" . $config . "' LIMIT 1;", 'config');
}

function inArray($array, $value) {
	if (is_array($array)) {
		if (in_array($value, $array)) {
			return TRUE;
		}else{
			return FALSE;
		}
	}else{
		return FALSE;
	}
}
?>