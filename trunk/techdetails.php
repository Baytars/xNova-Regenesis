<?php
/**
 * techdetails.php - Show the dependency tech tree
 * @author Perberos
 *
 * @package XNova
 * @version 0.8
 * @copyright (c) 2008,2009 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false)
{
   includeLang('login');
   message($lang['Login_Ok'], $lang['log_numbreg']);
}

$tech_id = intval($_GET['techid']);
// when the number have not requirements
if (!isset($requeriments[$tech_id]))
{
	die('Hacking Attempt');
}

$template = template_get('techtree_details');

$parse         = $lang;
$parse['id']   = $tech_id;
$parse['name'] = $lang['tech'][$tech_id];
$parse['list'] = array();

$jar = array(); // store all req array, we will use this like a jar
$jar[] = array($tech_id => 0);

$walk_level = 0;

// warning, bad configuration of vars can made crash this loop.
do
{
	$items = $jar[$walk_level];
	// increase for next items comers
	$walk_level++;

	$row = array();

	foreach ($items as $id => $lvl)
	{
		// if there is not requirements list, we ignore them
		if (!isset($requeriments[$id]))
		{
			continue;
		}

		// loop until all requirements are described
		foreach ($requeriments[$id] as $res_id => $level)
		{
			// we insert a new item to check the dependency
			if (!isset($jar[$walk_level][$res_id]) || $jar[$walk_level][$res_id]['level'] < $level)
			{
				$res = $resource[$res_id]; // only used for short writing
				// this item is used to parse {req_list/} ... {/req_list}
				$item = array();
				$item['id']    = $res_id;
				$item['name']  = $lang['tech'][$res_id];
				$item['level'] = $level;
				$item['Level']  = $lang['level'];
				// to show the current level
				$item['current'] = (isset($user[$res])) ? $user[$res] : $planetrow[$res];

				if (isset($requeriments[$res_id]))
				{
					$item['info'] = '<a href="?techid='.$res_id.'">[i]</a>';
				}

				if (isset($user[$res]) && $user[$res] >= $level)
				{
					$item['color'] = '#00ff00'; // green
				}
				elseif (isset($planetrow[$res]) && $planetrow[$res] >= $level)
				{
					$item['color'] = '#00ff00'; // green
				}
				else
				{
					$item['color'] = '#ff0000'; // red
				}

				$jar[$walk_level][$res_id] = $item;
			}
		}
	}

	// this is only for prevent bads and ugly vars.php
	if ($walk_level > 50)
	{
		break;
	}
}
while (isset($jar[$walk_level]));
// the order of requirements list reversed
$jar = array_reverse($jar);
array_pop($jar); // remove the useless last item
// the last thing to do
foreach ($jar as $number => $row)
{
	$list = array();
	$list['number'] = $number + 1;

	$req_list = array();

	foreach ($row as $item)
	{
		$req_list[] = $item;
	}

	$list['req_list'] = $req_list;

	$parse['list'][] = $list;
}

$page = template_parse($template, $parse);

display($page, $lang['Tech']);

?>
