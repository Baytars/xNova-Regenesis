<?php

/**
 * configstats.php
 *
 * @version 1.0
 * @copyright 2009 by angelus_ira for XNovaDuo
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);


if ( $user['authlevel'] >= 3 ) 
{	
	includeLang('admin/statsconfig');
	if ($_POST['save'] == $lang['lg_adm_save']) 
	{
		// Config if admin and GO have points in stats,and config the max acces_lvl for stats
		if (isset($_POST['stat']) && $_POST['stat'] != $game_config['stat']) 
		{
			update_config('stat', $_POST['stat']);
			$game_config['stat']	= $_POST['stat'];
		} 
		if (isset($_POST['stat_level']) &&  is_numeric($_POST['stat_level']) && $_POST['stat_level'] != $game_config['stat_level']) 
		{
			update_config('stat_level',  $_POST['stat_level']);
			$game_config['stat_level']	= $_POST['stat_level'];
		}
		if (isset($_POST['stat_flying']) && $_POST['stat_flying'] != $game_config['stat_flying']) 
		{
			update_config('stat_flying',  $_POST['stat_flying']);
			$game_config['stat_flying']	= $_POST['stat_flying'];
		}
		if (isset($_POST['stat_settings']) &&  is_numeric($_POST['stat_settings']) && $_POST['stat_settings'] != $game_config['stat_settings']) 
		{
			update_config('stat_settings',  $_POST['stat_settings']);
			$game_config['stat_settings']	= $_POST['stat_settings'];
		}
		if (isset($_POST['stat_amount']) &&  is_numeric($_POST['stat_amount']) && $_POST['stat_amount'] != $game_config['stat_amount'] && $_POST['stat_amount'] >= 10) 
		{
			update_config('stat_amount',  $_POST['stat_amount']);
			$game_config['stat_amount']	= $_POST['stat_amount'];
		}
		if (isset($_POST['stat_update_time']) &&  is_numeric($_POST['stat_update_time']) && $_POST['stat_update_time'] != $game_config['stat_update_time']) 
		{
			update_config('stat_update_time',  $_POST['stat_update_time']);
			$game_config['stat_update_time']	= $_POST['stat_update_time'];
		}
		AdminMessage ($lang['changes_applied'], $lang['adm_succes_title'], '?');
	}
	else
	{
	/*
		$tpl = new TemplatePower( $ugamela_root_path . 'templates/OpenGame/admin/configstats_body.tpl' );
		$tpl->prepare();
		$tpl->assignGlobal("dpath", $dpath);
		foreach($lang as $name => $trans)
		{
			$tpl->assignGlobal($name, $trans);
		}
		$selected= "selected=\"selected\"";
		$tpl->assign((($game_config['stat'] == 1)? 'sel_sta1':'sel_sta0'),  $selected);
		$tpl->assign("stat_level", $game_config['stat_level']);
		$tpl->assign(($game_config['stat_flying'] == 1)? "sel_sf1":"sel_sf0", $selected);
		$tpl->assign("stat_settings",  $game_config['stat_settings']);
		$tpl->assign("stat_amount",  $game_config['stat_amount']);
		$tpl->assign("stat_update_time",  $game_config['stat_update_time']);
		$admin_settings = $tpl->getOutputContent();
	*/
		$lang['dpath']	=	$dpath;
		$selected		=	"selected=\"selected\"";
		$stat			=	(($game_config['stat'] == 1)? 'sel_sta1':'sel_sta0');
		$lang[$stat]	=	$selected;
		$stat_fly		=	(($game_config['stat_flying'] == 1)? 'sel_sf1':'sel_sf0');
		$lang[$stat_fly]	=	$selected;
		$lang['stat_level']			=	$game_config['stat_level'];
		$lang['stat_settings']		=	$game_config['stat_settings'];
		$lang['stat_amount']		=	$game_config['stat_amount'];
		$lang['stat_update_time']	=	$game_config['stat_update_time'];
		
		$admin_settings = parsetemplate(gettemplate('admin/configstats_body'), $lang);
		display($admin_settings, $lang['adm_opt_title'], false);
	}
}
else
{
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>