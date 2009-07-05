<?php
/**
 * @author angelus_ira 
 * @package project.xnova.es
 * @version 0.1
 * @copyright (c) 2009 fantasiagames.com.ar
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
define('INSIDE'  , true);
define('INSTALL' , false);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
if ($_GET['mode'] == 'tac')
{
	includeLang('rules');
	$tp = new TemplatePower($ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME . "/rules.tpl" );
	$tp->prepare();
	foreach($lang['lg_tac_array'] as $a => $b)
	{
		// Rule block
		$tp->newBlock("rule");
		$b	= str_replace('%gn', $game_config['game_name'], $b);
		$tp->assign('rule_title', $a);
		$tp->assign('rule_content', $b);
	}
	$tp->gotoBlock("_ROOT");
	$tp->assign('lg_rules', $lang['lg_tac']);
	$r_expl	= str_replace('%gn', $game_config['game_name'], $lang['lg_tac_explain']);
	$tp->assign('rules_explain', $r_expl);
	$rules = $tp->getOutputContent();
	unset($lang);
	display($rules,$lang['lg_rules'], false);
}
else
{
	includeLang('rules');
	$tp = new TemplatePower($ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME . "/rules.tpl" );
	$tp->prepare();
	foreach($lang['lg_rules_array'] as $a => $b)
	{
		// Rule block
		$tp->newBlock("rule");
		$b	= str_replace('%gn', $game_config['game_name'], $b);
		$tp->assign('rule_title', $a);
		$tp->assign('rule_content', $b);
	}
	$tp->gotoBlock("_ROOT");
	$tp->assign('lg_rules', $lang['lg_rules']);
	$r_expl	= str_replace('%gn', $game_config['game_name'], $lang['lg_rules_explain']);
	$tp->assign('rules_explain', $r_expl);
	$rules = $tp->getOutputContent();
	unset($lang);
	display($rules,$lang['lg_rules'], false);
}
?>