<?php
/**
 * search.php
 * @version 1.2
 * @copyright 2009 by angelus_ira for Project. XNova
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
// blocking non-users
if ($IsUserChecked == false) 
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}
$searchtext = mysql_escape_string($_POST['searchtext']);
$type = $_POST['type'];
includeLang('search');
$i = 0;
//creamos la query
switch($type)
{
	case "playername":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$sql =	"SELECT
				u.id,u.username,u.id_planet,u.ally_id,
				p.name,p.galaxy,p.system,p.planet,
				a.ally_name,a.ally_tag,
				s.total_rank,s.total_points
				FROM
				{{table}}users AS u
				LEFT JOIN {{table}}planets AS p ON  p.id = u.id_planet
				LEFT JOIN {{table}}alliance AS a ON  a.id= u.ally_id
				LEFT JOIN {{table}}statpoints AS s ON s.id_owner =  u.id AND s.stat_type = 1
				WHERE
				u.username LIKE  '%{$searchtext}%'
				LIMIT 30;";
		$search = doquery($sql, '');
		unset($sql);
	break;
	case "planetname":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$sql = "SELECT 
				u.id,u.username,u.id_planet,u.ally_id,
				p.name,p.galaxy,p.system,p.planet,
				a.ally_name,a.ally_tag,
				s.total_rank,s.total_points
				FROM {{table}}planets as p
				LEFT JOIN {{table}}users as u ON u.id = p.id_owner
				LEFT JOIN {{table}}alliance as a ON  a.id= u.ally_id
				LEFT JOIN {{table}}statpoints as s ON s.id_owner =  p.id_owner AND s.stat_type = 1
				WHERE 
				p.name LIKE '%{$searchtext}%' 
				LIMIT 30;";
		$search = doquery($sql, '');
		unset($sql);
	break;
	case "allytag":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$sql=	"SELECT a.ally_name, a.id, a.ally_tag, a.ally_members, s.total_rank, s.total_points
				FROM {{table}}alliance AS a 
				LEFT JOIN {{table}}statpoints AS s ON a.id = s.id_owner AND s.stat_type = 2
				WHERE a.ally_tag LIKE  '%{$searchtext}%' LIMIT 30;";
		$search = doquery($sql,'');
		unset($sql);
	break;
	case "allyname":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$sql=	"SELECT a.ally_name, a.id, a.ally_tag, a.ally_members, s.total_rank, s.total_points
				FROM {{table}}alliance AS a 
				LEFT JOIN {{table}}statpoints AS s ON a.id = s.id_owner AND s.stat_type = 2
				WHERE a.ally_name LIKE  '%{$searchtext}%' LIMIT 30;";
		$search = doquery($sql,'');
		unset($sql);
	break;
	default:
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$sql =	"SELECT
				u.id,u.username,u.id_planet,u.ally_id,
				p.name,p.galaxy,p.system,p.planet,
				a.ally_name,a.ally_tag,
				s.total_rank,s.total_points
				FROM
				{{table}}users AS u
				LEFT JOIN {{table}}planets AS p ON  p.id = u.id_planet
				LEFT JOIN {{table}}alliance AS a ON  a.id= u.ally_id
				LEFT JOIN {{table}}statpoints AS s ON s.id_owner =  u.id AND s.stat_type = 1
				WHERE
				u.username LIKE  '%{$searchtext}%'
				LIMIT 30;";
		$search = doquery($sql, '');
		unset($sql);
}

if(isset($searchtext) && isset($type))
{
	while($r = mysql_fetch_array($search, MYSQL_BOTH))
	{
		if($type=='playername'||$type=='planetname')
		{
			$s=$r;
			//para obtener el nombre de la alianza
			$s['ally_name'] = ($s['ally_name']!='')?"<a href=\"alliance.php?mode=ainfo&tag={$s['ally_tag']}\">{$s['ally_name']}</a>":'';
			$s['position'] = "<a href=\"stat.php?start=".$s['total_rank']."\">".$s['total_rank']."</a>";
			$s['dpath'] = $dpath;
			$s['planet_name'] = $s['name'];		
			$s['coordinated'] = "{$s['galaxy']}:{$s['system']}:{$s['planet']}";
			$s['buddy_request'] = $lang['buddy_request'];
			$s['write_a_messege'] = $lang['write_a_messege'];
			$result_list .= parsetemplate($row, $s);
		}
		elseif($type=='allytag'||$type=='allyname')
		{
			$s=$r;
			$s['ally_points'] = pretty_number($s['total_points']);
			$s['ally_tag'] = "<a href=\"alliance.php?mode=ainfo&tag={$s['ally_tag']}\">{$s['ally_tag']}</a>";
			$result_list .= parsetemplate($row, $s);
		}
	}
	if($result_list!='')
	{
		$lang['result_list'] = $result_list;
		$search_results = parsetemplate($table, $lang);
	}
}
$lang['type_playername'] = ($_POST["type"] == "playername") ? " SELECTED" : "";
$lang['type_planetname'] = ($_POST["type"] == "planetname") ? " SELECTED" : "";
$lang['type_allytag'] = ($_POST["type"] == "allytag") ? " SELECTED" : "";
$lang['type_allyname'] = ($_POST["type"] == "allyname") ? " SELECTED" : "";
$lang['searchtext'] = $searchtext;
$lang['search_results'] = $search_results;
$page = parsetemplate(gettemplate('search_body'), $lang);
display($page,$lang['Search']);
?>