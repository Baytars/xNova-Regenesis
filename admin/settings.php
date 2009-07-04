<?php

/**
 * @settings.php
 * @mod by angelus_ira
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


if ( $user['authlevel'] >= 3 )
{
	includeLang('admin/settings');
	if ($_POST['save'] == $lang['lg_adm_opt_btn_save'])
	{
		// Game Name
		if (isset($_POST['game_name']) && $_POST['game_name'] != '' && $_POST['game_name'] != $game_config['game_name'])
		{
			update_config('game_name', $_POST['game_name']);
			$game_config['game_name']	= $_POST['game_name'];
		}
		//Forum Adress
		if (isset($_POST['forum_url']) && $_POST['forum_url'] != '' && $_POST['forum_url'] != $game_config['forum_url'])
		{
			update_config('forum_url', $_POST['forum_url']);
			$game_config['forum_url']	= $_POST['forum_url'];
		}
		// Game disable option
		if (isset($_POST['game_disable']) && $_POST['game_disable'] != $game_config['game_disable'])
		{
			update_config('game_disable', $_POST['game_disable']);
			$game_config['game_disable']	= $_POST['game_disable'];
		}
		if (isset($_POST['close_reason']) && $_POST['close_reason'] != $game_config['close_reason'])
		{
			update_config('close_reason', addslashes( $_POST['close_reason']));
			$game_config['close_reason']	= addslashes( $_POST['close_reason'] );
		}
		// Debug Mode
		if (isset($_POST['debug']) &&  $_POST['debug'] != $game_config['debug'])
		{
			update_config('debug', $_POST['debug']);
			$game_config['debug']	= $_POST['debug'];
		}
		// Game Speed
		if (isset($_POST['game_speed']) && $_POST['game_speed'] != '' &&  is_numeric($_POST['game_speed']) && $_POST['game_speed'] != $game_config['game_speed'])
		{
			update_config('game_speed', $_POST['game_speed']);
			$game_config['game_speed']	= $_POST['game_speed'];
		}
		// Fleets speed
		if (isset($_POST['fleet_speed']) && $_POST['fleet_speed'] != '' &&  is_numeric($_POST['fleet_speed']) && $_POST['fleet_speed'] != $game_config['fleet_speed'])
		{
			update_config('fleet_speed', $_POST['fleet_speed']);
			$game_config['fleet_speed']	= $_POST['fleet_speed'];
		}
		// Resources multiplier
		if (isset($_POST['resource_multiplier']) && $_POST['resource_multiplier'] != '' &&  is_numeric($_POST['resource_multiplier']) && $_POST['resource_multiplier'] != $game_config['resource_multiplier'])
		{
			update_config('resource_multiplier', $_POST['resource_multiplier']);
			$game_config['resource_multiplier']	= $_POST['resource_multiplier'];
		}
		// Initials fields in principal planet
		if (isset($_POST['initial_fields']) && $_POST['initial_fields'] != '' &&  is_numeric($_POST['initial_fields']) && $_POST['initial_fields'] != $game_config['initial_fields'])
		{
			update_config('initial_fields', $_POST['initial_fields']);
			$game_config['initial_fields']	= $_POST['initial_fields'];
		}
		// Metal basic income
		if (isset($_POST['metal_basic_income']) && $_POST['metal_basic_income'] != '' &&  is_numeric($_POST['metal_basic_income']) && $_POST['metal_basic_income'] != $game_config['metal_basic_income'])
		{
			update_config('metal_basic_income', $_POST['metal_basic_income']);
			$game_config['metal_basic_income']	= $_POST['metal_basic_income'];
		}
		// Crystal basic income
		if (isset($_POST['crystal_basic_income']) && $_POST['crystal_basic_income'] != '' &&  is_numeric($_POST['crystal_basic_income']) && $_POST['crystal_basic_income'] != $game_config['crystal_basic_income'])
		{
			update_config('crystal_basic_income', $_POST['crystal_basic_income']);
			$game_config['crystal_basic_income']	= $_POST['crystal_basic_income'];
		}
		// deuterium basic income
		if (isset($_POST['deuterium_basic_income']) && $_POST['deuterium_basic_income'] != '' &&  is_numeric($_POST['deuterium_basic_income']) && $_POST['deuterium_basic_income'] != $game_config['deuterium_basic_income'])
		{
			update_config('deuterium_basic_income', $_POST['deuterium_basic_income']);
			$game_config['deuterium_basic_income']	= $_POST['deuterium_basic_income'];
		}
		// Energy basic income
		if (isset($_POST['energy_basic_income']) && $_POST['energy_basic_income'] != '' &&  is_numeric($_POST['energy_basic_income']) && $_POST['energy_basic_income'] != $game_config['energy_basic_income'])
		{
			update_config('energy_basic_income', $_POST['energy_basic_income']);
			$game_config['energy_basic_income']	= $_POST['energy_basic_income'];
		}
		// Attack system conifg
		if (isset($_POST['attack_disabled']) && $_POST['attack_disabled'] != $game_config['attack_disabled'])
		{
			update_config('attack_disabled', $_POST['attack_disabled']);
			$game_config['attack_disabled']	= $_POST['attack_disabled'];
		}
		if ($_POST['AtakBlockTime'] &&  is_numeric($_POST['AtakBlockTime']))
		{
			$hour = $_POST['AtakBlockTime'];
			$Now = time();
			$AtakBlockTime += $hour * 3600;
			$AtakBlockUntil = $Now + $AtakBlockTime;
			update_config('AtackBlocEnd',  $AtakBlockUntil);
			$game_config['AtackBlocEnd']	= $AtakBlockUntil;
			update_config('AtackBlocStart',  $Now);
			$game_config['AtackBlocStart']	= $Now;
		}
		// Config News Frames in overview
		if (isset($_POST['OverviewNewsFrame']) && $_POST['OverviewNewsFrame'] != $game_config['OverviewNewsFrame'])
		{
			update_config('OverviewNewsFrame', $_POST['OverviewNewsFrame']);
			$game_config['OverviewNewsFrame']	= $_POST['OverviewNewsFrame'];
		}
		if (isset($_POST['OverviewNewsText']) && $_POST['OverviewNewsText'] != $game_config['OverviewNewsText'])
		{
			update_config('OverviewNewsText', addslashes( $_POST['OverviewNewsText']));
			$game_config['OverviewNewsText']	= addslashes( $_POST['OverviewNewsText'] );
		}
		// Config external chat adress
		if (isset($_POST['OverviewExternChat']) && $_POST['OverviewExternChat'] != $game_config['OverviewExternChat'])
		{
			update_config('OverviewExternChat', $_POST['OverviewExternChat']);
			$game_config['OverviewExternChat']	= $_POST['OverviewExternChat'];
		}
		if (isset($_POST['OverviewExternChatCmd']) && $_POST['OverviewExternChatCmd'] != $game_config['OverviewExternChatCmd'])
		{
			update_config('OverviewExternChatCmd', addslashes( $_POST['OverviewExternChatCmd']));
			$game_config['OverviewExternChatCmd']	= addslashes( $_POST['OverviewExternChatCmd'] );
		}
		//Config ads space
		if (isset($_POST['OverviewBanner']) && $_POST['OverviewBanner'] != $game_config['OverviewBanner'])
		{
			update_config('OverviewBanner', $_POST['OverviewBanner']);
			$game_config['OverviewBanner']	= $_POST['OverviewBanner'];
		}
		if (isset($_POST['OverviewClickBanner']) && $_POST['OverviewClickBanner'] != $game_config['OverviewClickBanner'])
		{
			update_config('OverviewClickBanner', addslashes( $_POST['OverviewClickBanner']));
			$game_config['OverviewClickBanner']	= addslashes( $_POST['OverviewClickBanner'] );
		}
		AdminMessage ($lang['changes_applied'], $lang['adm_succes_title'], '?');
	}
	else
	{
		$tpl = new TemplatePower( $ugamela_root_path . 'templates/OpenGame/admin/settings_body.tpl' );
		$tpl->prepare();
		$tpl->assignGlobal("dpath", $dpath);
		foreach($lang as $name => $trans)
		{
			$tpl->assignGlobal($name, $trans);
		}
		$tpl->assign("game_name", $game_config['game_name']);
		$tpl->assign("game_speed", $game_config['game_speed']);
		$tpl->assign("fleet_speed", $game_config['fleet_speed']);
		$tpl->assign("resource_multiplier", $game_config['resource_multiplier']);
		$tpl->assign("forum_url", $game_config['forum_url']);
		$tpl->assign("initial_fields", $game_config['initial_fields']);
		$tpl->assign("metal_basic_income", $game_config['metal_basic_income']);
		$tpl->assign("crystal_basic_income", $game_config['crystal_basic_income']);
		$tpl->assign("deuterium_basic_income", $game_config['deuterium_basic_income']);
		$tpl->assign("energy_basic_income", $game_config['energy_basic_income']);
		$selected= "selected=\"selected\"";
		$tpl->assign(($game_config['game_disable'] == 1)? "sel_gd1":"sel_gd0", $selected);
		$tpl->assign("close_reason", stripslashes( $game_config['close_reason']));
		$tpl->assign(($game_config['debug'] == 1)? 'sel_deb1':'sel_deb0',  $selected);
		$tpl->assign(($game_config['attack_disabled'] == 1)? 'sel_att1':'sel_att0',  $selected);
		$time_disabled=(($game_config['AtackBlocEnd'])-($game_config['AtackBlocStart']))/3600;
		$tpl->assign("hour", $time_disabled);
		$tpl->assign(($game_config['OverviewNewsFrame'] == 1)? 'sel_new1':'sel_new0',  $selected);
		$tpl->assign("NewsTextVal", stripslashes( $game_config['OverviewNewsText']));
		$tpl->assign(($game_config['OverviewBanner'] == 1)? 'sel_ban1':'sel_ban0',  $selected);
		$tpl->assign("GoogleAdVal", stripslashes( $game_config['OverviewClickBanner'] ));
		$tpl->assign(($game_config['OverviewExternChat'] == 1)? 'sel_cha1':'sel_cha0',  $selected);
		$tpl->assign("GoogleAdVal", stripslashes( $game_config['OverviewExternChatCmd'] ));
		$admin_settings = $tpl->getOutputContent();
		display($admin_settings, $lang['adm_opt_title'], false);
	}
}
else
{
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>