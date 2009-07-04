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


//Activation or grettings mail function...
function sendpassemail($emailaddress, $username, $password, $siteurlactivationlink)
{
	global $lang, $game_config;
	$to = $emailaddress;
	$replace	= array($game_config['game_name'], $username, $password, $siteurlactivationlink);
	$orig		= array('%gn', '%u','%p','%al');
	$mail_title = str_replace($orig, $replace,$lang['lg_mail_title']);
	$mail_body	= str_replace($orig, $replace,$lang['lg_mail_intro']);
	if ($game_config['reg_mail'] == 1 && $game_config['reg_act'] == 1)
	{
		$mail_body	.= str_replace($orig, $replace,$lang['lg_mail_act']);
	}
	$mail_body	.= str_replace($orig, $replace,$lang['lg_mail_intro']);
	$from = $game_config['game_name'];
	$status            = mail($to, $mail_title, $mail_body , "From: $from");
	return $status;
}

if ($game_config['reg_bot'] =='recaptcha')
{
	//Recaptcha
	require_once($ugamela_root_path . 'includes/recaptchalib.' . $phpEx);
	// Get a key from http://recaptcha.net/api/getkey
	$publickey = $game_config['rec_publickey'];
	$privatekey = $game_config['rec_privatekey'];
	// the response from reCAPTCHA
	$resp = null;
	// the error code from reCAPTCHA, if any
	$error = null;
}
//Post section
if ($_POST)
{
	$errors    = 0;
	$errorlist = "";
	if ($game_config['reg_bot'] =='recaptcha')
	{
		//Recaptcha
		// was there a reCAPTCHA response?
		if ($_POST["recaptcha_response_field"])
		{
			$resp = recaptcha_check_answer ($privatekey,
											$_SERVER["REMOTE_ADDR"],
											$_POST["recaptcha_challenge_field"],
											$_POST["recaptcha_response_field"]);
		}
		if (!$resp->is_valid)
		{
			$errorlist .= $lang['lg_e_captcha'];
			$errors++;
		}
	}
	//securimage
	if ($game_config['reg_bot'] =='captcha')
	{	
		include($ugamela_root_path . 'class/securimage/securimage.' . $phpEx);
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) 
		{
			$errorlist .= $lang['lg_e_captcha'];
			$errors++;
		}
	}
	$_POST['email'] = strip_tags($_POST['email']);
	if (!is_email($_POST['email']))
	{
		$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['lg_e_mail'];
		$errors++;
	}
	if (!$_POST['planet'])
	{
		$errorlist .= $lang['lg_e_planet'];
		$errors++;
	}
	if (!$_POST['username'])
	{
		$errorlist .= $lang['lg_e_username'];
		$errors++;
	}
	if (strlen($_POST['password']) < 4)
	{
		$errorlist .= $lang['lg_e_password'];
		$errors++;
	}
	if (!Check_chars($_POST['username']))
	{
		$errorlist .= $lang['lg_e_useralpha'];
		$errors++;
	}
	if (!Check_chars($_POST['planet']))
	{
		$errorlist .= $lang['lg_e_planetalpha'];
		$errors++;
	}
	if ($_POST['rgt'] != 'on')
	{
		$errorlist .= $lang['lg_e_rgt'];
		$errors++;
	}
	if ($_POST['sex'] != ''  && $_POST['sex'] != 'F' && $_POST['sex'] != 'M')
	{
		$errorlist .= $lang['lg_e_sex'];
		$errors++;
	}
	if (!$_POST['language'])
	{
		$errorlist .= $lang['lg_e_language'];
		$errors++;
	}
	// Control for existing users
	$existing_user = doquery("SELECT `username` FROM {{table}} WHERE `username` = '". mysql_real_escape_string($_POST['username']) ."' LIMIT 1;", 'users', true);
	if ($existing_user)
	{
		$errorlist .= $lang['lg_e_userexist'];
		$errors++;
	}
	// Just 1 account for mail
	$existing_mail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". mysql_real_escape_string($_POST['email']) ."' LIMIT 1;", 'users', true);
	if ($existing_mail)
	{
		$errorlist .= $lang['lg_e_emailexist'];
		$errors++;
	}
	if ($errors != 0  )
	{
		message ($errorlist, $lang['lg_registry'],'login.php',6);
	}
	else
	{
		$user_pass        = $_POST['password'];
		//TODO make a better CheckInputStrings function...
		$user_name       = CheckInputStrings ( $_POST['username'] );
		$user_email      = CheckInputStrings ( $_POST['email'] );
		$user_planet     = CheckInputStrings ( $_POST['planet'] );
		$user_pass_md5     = md5($user_pass);
		//Activate status
		if ($game_config['reg_act'] == 1)
		{
			$user_act_status	= 0;
		}
		else
		{
			$user_act_status	= 1;
		}
		// User creation
		$user_query  = "INSERT INTO {{table}} SET ";
		$user_query .= "`username` = '". mysql_real_escape_string(strip_tags( $user_name )) ."', ";
		$user_query .= "`activate_status` = '".$user_act_status."', ";
		$user_query .= "`email` = '".    mysql_real_escape_string( $user_email )            ."', ";
		$user_query .= "`lang` = '".     mysql_real_escape_string( $_POST['language'] )      ."', ";
		$user_query .= "`email_2` = '".  mysql_real_escape_string( $user_email )            ."', ";
		$user_query .= "`sex` = '".      mysql_real_escape_string( $_POST['sex'] )         ."', ";
		$user_query .= "`id_planet` = '0', ";
		$user_query .= "`register_time` = '". time() ."', ";
		$user_query .= "`password`='". $user_pass_md5 ."';";
		doquery( $user_query, 'users');
		// Make the new user id
		$new_user        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". mysql_real_escape_string($_POST['username']) ."' LIMIT 1;", 'users', true);
		// Search a galaxy space...
		$last_setted_g_pos  = $game_config['LastSettedGalaxyPos'];
		$last_setted_s_pos  = $game_config['LastSettedSystemPos'];
		$last_setted_p_pos  = $game_config['LastSettedPlanetPos'];
		while (!isset($newpos_checked))
		{
			for ($Galaxy = $last_setted_g_pos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++)
			{
				for ($System = $last_setted_s_pos; $System <= MAX_SYSTEM_IN_GALAXY; $System++)
				{
					for ($Posit = $last_setted_p_pos; $Posit <= 4; $Posit++)
					{
						$Planet = round (rand ( 4, 12) );

						switch ($last_setted_p_pos)
						{
						case 1:
							$last_setted_p_pos += 1;
							break;
						case 2:
							$last_setted_p_pos += 1;
							break;
						case 3:
							if ($last_setted_s_pos == MAX_SYSTEM_IN_GALAXY)
							{
								$last_setted_g_pos += 1;
								$last_setted_s_pos  = 1;
								$last_setted_p_pos  = 1;
								break;
							}
							else
							{
								$last_setted_p_pos  = 1;
							}
							$last_setted_s_pos += 1;
							break;
						}
						break;
					}
					break;
				}
				break;
			}
			$galaxy_query  =	"SELECT * ";
			$galaxy_query .= "FROM {{table}} ";
			$galaxy_query .= "WHERE ";
			$galaxy_query .= "`galaxy` = '". $Galaxy ."' AND ";
			$galaxy_query .= "`system` = '". $System ."' AND ";
			$galaxy_query .= "`planet` = '". $Planet ."' ";
			$galaxy_query .= "LIMIT 1;";
			$GalaxyRow = doquery( $galaxy_query, 'galaxy', true);
			if ($GalaxyRow["id_planet"] == "0")
			{
				$newpos_checked = true;
			}
			if (!$GalaxyRow)
			{
				CreateOnePlanetRecord ($Galaxy, $System, $Planet, $new_user['id'], $user_planet,false,false,false, true);
				$newpos_checked = true;
			}
			if ($newpos_checked)
			{
				doquery("UPDATE {{table}} SET `config_value` = '". $last_setted_g_pos ."' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $last_setted_s_pos ."' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $last_setted_p_pos ."' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			}
		}
		// Make the id_planet id
		$planet_id = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $new_user['id'] ."' LIMIT 1;", 'planets', true);
		// Set mother planet of the user
		$user_update_query  = "UPDATE {{table}} SET ";
		$user_update_query .= "`id_planet` = '". $planet_id['id'] ."', ";
		$user_update_query .= "`current_planet` = '". $planet_id['id'] ."', ";
		$user_update_query .= "`galaxy` = '". $Galaxy ."', ";
		$user_update_query .= "`system` = '". $System ."', ";
		$user_update_query .= "`planet` = '". $Planet ."' ";
		$user_update_query .= "WHERE ";
		$user_update_query .= "`id` = '". $new_user['id'] ."' ";
		$user_update_query .= "LIMIT 1;";
		doquery( $user_update_query, 'users');
		//Change the register users
		doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
		doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'aktywacjen' LIMIT 1;", 'config');
		$welcome_message  =$lang['lg_thanks_for_reg'];
		if ($game_config['reg_act'] == 1)
		{
			//Add the activation link
			$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
			$url=dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']).DIRECTORY_SEPARATOR;
			$siteurlactivationlink = $url.'activate.php?hash='.base64_encode($_POST['username']).'&stamp='.base64_encode($new_user['id']).'&mode=reg';
			$welcome_message .= $lang['lg_reg_act_end'];
		}
		if 	($game_config['reg_mail'] == 1)
		{
			if ( sendpassemail($user_email,$user_name, $user_pass, $siteurlactivationlink))
			{
				$welcome_message .= " (" . htmlentities($_POST["email"]) . ") <br>";
			}
			else
			{
				$welcome_message .= str_replace(array('%ma','%p'), array($user_email,$user_pass), $lang['lg_e_mailsend']);
			}
		}
		$welcome_message .= $lang['lg_reg_end'];
		message( $welcome_message,$lang['lg_thanks_for_reg'],"../index.".$phpEx);
		$game_message	= str_replace('%gn', $game_config['game_name'], $lang['lg_reg_simple_msg']);
		SendSimpleMessage ( $new_user['id'], 1, time(), 1, $game_config['game_name'], $lang['lg_reg_welldone'], $game_message);
	}
}
else
{
	// Reg form
	$tpl = new TemplatePower( $ugamela_root_path . 'templates/OpenGame/registry_form.tpl' );
	$tpl->prepare();
	$tpl->assignGlobal("dpath", $dpath);
	foreach($lang as $name => $trans)
	{
		$tpl->assignGlobal($name, $trans);
	}
	$tpl->assign("rec_publickey", $game_config['rec_publickey']);
	$tpl->assign("servername", $game_config['game_name']);
	$tpl->assign($lang['lg_lang']);
	if ($game_config['reg_bot'] =='recaptcha')
	{
		$tpl->newBlock("recaptcha");
	}
	if ($game_config['reg_bot'] =='captcha')
	{
		$tpl->newBlock("captcha");
	}
	$registry_page = $tpl->getOutputContent();
	display ($registry_page, $lang['registry'], false);
}
// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle
// 1.1 - Menage + rangement + utilisation fonction de creation planete nouvelle generation
// 1.2 -Account Activation and recaptcha by Darksoldier
// 1.3 - Remake of the registry page, add captcha and config settings, Using templatepower. Changes by angelus_ira
?>