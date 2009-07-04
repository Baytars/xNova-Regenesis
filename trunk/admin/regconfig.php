<?php

/**
 * @regconfig.php
 * @by angelus_ira www.fantasiagames.com.ar
 * @version 1.0
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


if ( $user['authlevel'] >= 3 )
{
	includeLang('admin/regconfig');
	if ($_POST['save'] == $lang['lg_adm_save'])
	{
		// Recaptcha Public Key
		if (isset($_POST['rec_publickey']) && $_POST['rec_publickey'] != '' && $_POST['rec_publickey'] != $game_config['rec_publickey'])
		{
			update_config('rec_publickey', $_POST['rec_publickey']);
			$game_config['rec_publickey']	= $_POST['rec_publickey'];
		}
		// Recaptcha Private  Key
		if (isset($_POST['rec_privatekey']) && $_POST['rec_privatekey'] != '' && $_POST['rec_privatekey'] != $game_config['rec_privatekey'])
		{
			update_config('rec_privatekey', $_POST['rec_privatekey']);
			$game_config['rec_privatekey']	= $_POST['rec_privatekey'];
		}
		// Send mail in reg config
		if (isset($_POST['reg_mail']) && $_POST['reg_mail'] != $game_config['reg_mail'])
		{
			update_config('reg_mail', $_POST['reg_mail']);
			$game_config['reg_mail']	= $_POST['reg_mail'];
		}
		//Activate account config
		if (isset($_POST['reg_act']) && $_POST['reg_act'] != $game_config['reg_act'])
		{
			update_config('reg_act', $_POST['reg_act']);
			$game_config['reg_act']	= $_POST['reg_act'];
		}
		// Antibot Config
		if (isset($_POST['reg_bot']) &&  $_POST['reg_bot'] != $game_config['reg_bot'])
		{
			update_config('reg_bot', $_POST['reg_bot']);
			$game_config['reg_bot']	= $_POST['reg_bot'];
		}
		AdminMessage ($lang['lg_adm_applied'], $lang['lg_adm_reg_cfg'], '?');
	}
	else
	{
		$tpl = new TemplatePower( $ugamela_root_path . 'templates/OpenGame/admin/regconfig.tpl' );
		$tpl->prepare();
		$tpl->assignGlobal("dpath", $dpath);
		foreach($lang as $name => $trans)
		{
			$tpl->assignGlobal($name, $trans);
		}
		$tpl->assign("rec_publickey", $game_config['rec_publickey']);
		$tpl->assign("rec_privatekey", $game_config['rec_privatekey']);
		$selected= "selected=\"selected\"";
		$tpl->assign(($game_config['reg_mail'] == 1)? 'sel_mail2':'sel_mail1', $selected);
		$tpl->assign(($game_config['reg_act'] == 1)? 'sel_act2':'sel_act1',  $selected);
		if ($game_config['reg_bot'] == 'recaptcha')
		{
			$tpl->assign("sel_bot2", $selected);
		}
		elseif ($game_config['reg_bot'] == 'captcha')
		{
			$tpl->assign("sel_bot3", $selected);
		}
		else
		{
			$tpl->assign("sel_bot1", $selected);
		}
		$admin_settings = $tpl->getOutputContent();
		display($admin_settings, $lang['adm_opt_title'], false);
	}
}
else
{
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>