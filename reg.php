<?php

/**
 * reg.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

includeLang('reg');

/*
function sendpassemail($emailaddress, $password, $siteurlactivationlink) {
	global $lang, $kod;

	$parse['gameurl']  = GAMEURL;
	$parse['password'] = $password;
	//Mod activar cuenta via mail de activacion
	$parse['activatelink'] = $siteurlactivationlink;
	$parse['kod']      = $kod;
	$email             = parsetemplate($lang['mail_welcome'], $parse);	
	$status            = mail($emailaddress, $lang['mail_title'], $email);
	return $status;
}*/
require_once($ugamela_root_path . 'includes/recaptchalib.' . $phpEx);

// Get a key from http://recaptcha.net/api/getkey
$publickey = "tu codigo";
$privatekey = "tu codigo";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
   
}
// echo recaptcha_get_html($publickey, $error);  //con esta linea aparece en el IE, pero no funciona y no se puede colocar centrado se queda x=0 y=0

function sendpassemail($emailaddress, $password, $siteurlactivationlink) {
global $lang, $kod;
		$to = $emailaddress;
		$title = "Bienvenido a tu server";
		$parse['activatelink'] = $siteurlactivationlink;
		$parse['kod']      = $kod;
		$cuerpo = "Bienvenido a tu server

		Te has registrado con el siguiente nombre de usuario: ". mysql_escape_string($_POST['character']) ."
		Tu contraseña es: ". mysql_escape_string($_POST['passwrd']) . "
		
		Para jugar en ". $game_config['game_name'] ." es necesario que actives tu cuenta.

		Has click en el siguiente link para confirmar tu registro. 
		". $siteurlactivationlink ."

		Si no puedes entrar pulsando el enlace superior.
		Copia y pega el siguiente enlace en tu navegador y entra para validarte.

		Desde la Administración de ". $game_config['game_name'] ." te agradecemos tu confianza";
		$from = "administracion@tu server";
        $email             = parsetemplate($cuerpo , $parse);
		$status            = mail($to, $title, $cuerpo , "From: $from");
	return $status;
}

if ($_POST) {
	$errors    = 0;
	$errorlist = "";

	$_POST['email'] = strip_tags($_POST['email']);
	if (!is_email($_POST['email'])) {
		$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail'];
		$errors++;
	}
	if (!$resp->is_valid){
	$errorlist .= $lang['error_captcha']; 
	$errors++; 
	}

	if (!$_POST['planet']) {
		$errorlist .= $lang['error_planet'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['hplanet']) == 1) {
		$errorlist .= $lang['error_planetnum'];
		$errors++;
	}

	if (!$_POST['character']) {
		$errorlist .= $lang['error_character'];
		$errors++;
	}

	if (strlen($_POST['passwrd']) < 4) {
		$errorlist .= $lang['error_password'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1) {
		$errorlist .= $lang['error_charalpha'];
		$errors++;
	}

	if ($_POST['rgt'] != 'on') {
		$errorlist .= $lang['error_rgt'];
		$errors++;
	}

	// Le meilleur moyen de voir si un nom d'utilisateur est pris c'est d'essayer de l'appeler !!
	$ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
	if ($ExistUser) {
		$errorlist .= $lang['error_userexist'];
		$errors++;
	}

	// Si l'on verifiait que l'adresse email n'existe pas encore ???
	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". mysql_escape_string($_POST['email']) ."' LIMIT 1;", 'users', true);
	if ($ExistMail) {
		$errorlist .= $lang['error_emailexist'];
		$errors++;
	}

	if ($_POST['sex'] != ''  &&
		$_POST['sex'] != 'F' &&
		$_POST['sex'] != 'M') {
		$errorlist .= $lang['error_sex'];
		$errors++;
	}
	if ($_POST['langer'] != ''  &&
		$_POST['langer'] != 'es') {
		$errorlist .= $lang['error_lang'];
		$errors++;
	}
		

	if ($errors != 0  ) {
		message ($errorlist, $lang['Register'],'login.php',6);
	} else {
		$newpass        = $_POST['passwrd'];
		$UserName       = CheckInputStrings ( $_POST['character'] );
		$UserEmail      = CheckInputStrings ( $_POST['email'] );
		$UserPlanet     = CheckInputStrings ( $_POST['planet'] );

		$md5newpass     = md5($newpass);
		
		// Creation de l'utilisateur
		$QryInsertUser  = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '". mysql_escape_string(strip_tags( $UserName )) ."', ";
		$QryInsertUser .= "`email` = '".    mysql_escape_string( $UserEmail )            ."', ";
		$QryInsertUser .= "`lang` = '".     mysql_escape_string( $_POST['langer'] )      ."', ";
		$QryInsertUser .= "`email_2` = '".  mysql_escape_string( $UserEmail )            ."', ";
		$QryInsertUser .= "`sex` = '".      mysql_escape_string( $_POST['sex'] )         ."', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`register_time` = '". time() ."', ";
		$QryInsertUser .= "`password`='". $md5newpass ."';";		
		doquery( $QryInsertUser, 'users');

		// On cherche le numero d'enregistrement de l'utilisateur fraichement créé
		$NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
		$iduser         = $NewUser['id'];
        //Mod activar cuenta via mail de activacion by darksoldier
		$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
		$url=dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']).DIRECTORY_SEPARATOR;        
		$siteurlactivationlink = $url.'activate.php?hash='.base64_encode($_POST['character']).'&stamp='.base64_encode($NewUser['id']).'&mode=reg';
		// Recherche d'une place libre !
		$LastSettedGalaxyPos  = $game_config['LastSettedGalaxyPos'];
		$LastSettedSystemPos  = $game_config['LastSettedSystemPos'];
		$LastSettedPlanetPos  = $game_config['LastSettedPlanetPos'];
		while (!isset($newpos_checked)) {
			for ($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++) {
				for ($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System++) {
					for ($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit++) {
						$Planet = round (rand ( 4, 12) );

						switch ($LastSettedPlanetPos) {
							case 1:
								$LastSettedPlanetPos += 1;
								break;
							case 2:
								$LastSettedPlanetPos += 1;
								break;
							case 3:
								if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
									$LastSettedGalaxyPos += 1;
									$LastSettedSystemPos  = 1;
									$LastSettedPlanetPos  = 1;
									break;
								} else {
									$LastSettedPlanetPos  = 1;
								}
								$LastSettedSystemPos += 1;
								break;
						}
						break;
					}
					break;
				}
				break;
			}

			$QrySelectGalaxy  =	"SELECT * ";
			$QrySelectGalaxy .= "FROM {{table}} ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QrySelectGalaxy .= "`system` = '". $System ."' AND ";
			$QrySelectGalaxy .= "`planet` = '". $Planet ."' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$GalaxyRow = doquery( $QrySelectGalaxy, 'galaxy', true);

			if ($GalaxyRow["id_planet"] == "0") {
				$newpos_checked = true;
			}

			if (!$GalaxyRow) {
				CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet,false,false,false, true);
				$newpos_checked = true;
			}
			if ($newpos_checked) {
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedGalaxyPos ."' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedSystemPos ."' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedPlanetPos ."' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			}
		}
		// Recherche de la reference de la nouvelle planete (qui est unique normalement !
		$PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

		// Mise a jour de l'enregistrement utilisateur avec les infos de sa planete mere
		$QryUpdateUser  = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`id_planet` = '". $PlanetID['id'] ."', ";
		$QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."', ";
		$QryUpdateUser .= "`galaxy` = '". $Galaxy ."', ";
		$QryUpdateUser .= "`system` = '". $System ."', ";
		$QryUpdateUser .= "`planet` = '". $Planet ."' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '". $NewUser['id'] ."' ";
		$QryUpdateUser .= "LIMIT 1;";
		doquery( $QryUpdateUser, 'users');

		// Mise a jour du nombre de joueurs inscripts
		doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
        doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'aktywacjen' LIMIT 1;", 'config');
		
		$Message  = $lang['thanksforregistry'];
		if ( sendpassemail($_POST['email'], "$newpass", $siteurlactivationlink)) {
         $Message .= " (" . htmlentities($_POST["email"]) . ")";
		} else {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
			$Message .= "<br><br>". $lang['error_mailsend'] ." <b>" . $newpass . "</b>";
		}
		 message( $Message,'Gracias por registrarte',"../index.".$phpEx);
		$Message = "Bienvenidos a ".$game_config['game_name'].", desde la Administracion queremos darle las gracias por confiar en nosotros. Le recordamos que dispone a su disposicion del un foro donde consultar cualquier pregunta. Le sugerimos que empiece construyendo la planta de energia solar, seguido de las minas de metal y cristal. Buena suerte y que disfrute del juego";
		SendSimpleMessage ( $NewUser['id'], 1, time(), 1, $game_config['game_name'], "Bienvenido", $Message);
	}
} else {
	// Afficher le formulaire d'enregistrement
	$parse               = $lang;
	$parse['servername'] = $game_config['game_name'];
	$parse['tucodigo']   = $publickey;
	$page                = parsetemplate(gettemplate('registry_form'), $parse);

	display ($page, $lang['registry'], false);
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle
// 1.1 - Menage + rangement + utilisation fonction de creation planete nouvelle generation
// 1.2 -Account Activation and recaptcha by Darksoldier
?>
