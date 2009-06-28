<?php
/**
 * techtree.php - Tech Tree
 * Using the new templates system!
 *
 * @author Perberos
 * @author Chlorel
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

// we get the template
$parse    = $lang;
$template = template_get('techtree');

// reslist store info about each type of resources or techs
foreach ($reslist as $type => $type_row)
{
	// this is only to know what kind of thing is
	switch ($type)
	{
		case 'build':
			$type = $lang['tech'][0];
		break;

		case 'tech':
			$type = $lang['tech'][100];
		break;

		case 'fleet':
			$type = $lang['tech'][200];
		break;

		case 'defense':
			$type = $lang['tech'][400];
		break;

		case 'officier':
			$type = $lang['tech'][600];
		break;

		default: // not a tech
			continue 2; // returning to the next foreach
		break;
	}

	// we declare the header
	$list = array();
	$list['name'] = $type;
	$list['Requirements'] = $lang['Requirements'];

	foreach ($type_row as $id)
	{
		// this array parse the {row/} ... {/row}
		$row = array();

		$row['id']   = $id;
		$row['name'] = $lang['tech'][$id];

		// this show a requirements list of the tech or thing
		if (isset($requeriments[$id]))
		{
			$required_list = '';

			foreach ($requeriments[$id] as $req_id => $req_level)
			{
				$res = $resource[$req_id]; // only used for the conditions

				if (isset($user[$res]) && $user[$res] >= $req_level)
				{
					$required_list .= '<font color="#00ff00">';
				}
				elseif (isset($planetrow[$res]) && $planetrow[$res] >= $req_level)
				{
					$required_list .= '<font color="#00ff00">';
				}
				else
				{
					$required_list .= '<font color="#ff0000">';
				}
				// a little long?
				$required_list .= $lang['tech'][$req_id].' ( '.$lang['level'].
					' '.$user[$res].' '.$planetrow[$res].' / '.$req_level.
					' )</font><br>';
			}
			// adding the requirements list with colors
			$row['required_list'] =  $required_list;
			// techdetails only show techs with requirements
			$row['detail'] =  '<a href="techdetails.php?techid='.$id.'">'.
				$lang['treeinfo'].'</a>';
		}
		// add one item to the list row
		$list['row'][] = $row;
	}
	// add one item to the list
	$parse['list'][] = $list;
}

$page = template_parse($template, $parse);

display($page, $lang['Tech']);

?>
