<?php
/**
 * @author angelus_ira - angelus_ira@hotmail.com
 * @package XnovaDuo www.multinova.co.cc
 * @version 0.5
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Based on StatBuilder.php by Chlorel for XNova copyright 2008 
 */
define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
include($ugamela_root_path . 'admin/statfunctions.' . $phpEx);
includeLang('admin/statsconfig');

if ($user['authlevel'] >= 2) 
{
	$result		=MakeStats();
	$memory_p	= str_replace(array("%p", "%m"), $result['memory_peak'], $lang['adm_memory_peak']);
	$memory_e	= str_replace(array("%e", "%m"), $result['end_memory'], $lang['adm_e_memory']);
	$memory_i	= str_replace(array("%i", "%m"), $result['initial_memory'], $lang['adm_i_memory']);
	$stats_end_time	= str_replace("%t", $result['totaltime'], $lang['adm_total_time']);
	$stats_block	= str_replace("%n", $result['amount_per_block'], $lang['adm_stat_block']);
	//We change the config stats last update time.
	update_config( 'stat_last_update', $result['stats_time']);
	$using_flying=(($game_config['stat_flying']==1)?$lang['adm_flying']	:$lang['adm_no_flying']);
	$message	= $lang['adm_stat_end'].$stats_end_time.$memory_i.$memory_e.$memory_p.$stats_block.$using_flying;
	AdminMessage ( $message, $lang['adm_stat_title'] );
} 
else 
{
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>