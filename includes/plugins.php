<?php
/**
 * An ugly plugins system for Xnova, a gift from DSC 1.1
 * @author Perberos
 *
 * @package XNova
 * @version 0.8
 * @copyright (c) 2008,2009 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('INSIDE'))
{
	die('Hacking attempt');
}

// return the name of php file without extension
function phpself()
{
	global $ugamela_root_path;

	$file = pathinfo($_SERVER['PHP_SELF']);
	// fix for PHP PHP 4 > 5.2.0
	if (version_compare(PHP_VERSION, '5.2.0', '<'))
	{
		$file['filename'] = substr($file['basename'], 0,
			strlen($file['basename']) - strlen($file['extension']) - 1);
	}
	if (basename($ugamela_root_path) != '.')
	{
		return basename($file['dirname']).'/'.$file['filename'];
	}
	else
	{
		return $file['filename'];
	}
}

// return if a name of php file is same of $name
function is_phpself($name)
{
	return (phpself() == $name);
}

/**
 * This system is little similar to the punBB hook system, but it is more
 * insecured and lazy.
 *
 * Now the code must be populated with:
 * ($hook = get_hook('NameOfHook')) ? eval($hook) : null;
 */

// this function store code into an array
function set_hook($name, $code)
{
	global $plugins_hooks;

	$plugins_hooks[$name][] = $code;
}
// this is used to get all code for the hook
function get_hook($name)
{
	global $plugins_hooks;

	if (isset($plugins_hooks[$name]))
	{
		return implode('', $plugins_hooks[$name]);
	}
}

// making a little better the code using 1 var instead 2
$plugins_path = $ugamela_root_path.'plugins/';
// this variable is only for compatibility reasons, using version_compare()
$plugins_version = '0.2';
// this array is used to store code for actions trigger in some hooks
$plugins_hooks = array();
// open all files inside plugins folder
$dir = opendir($plugins_path);

while (($file = readdir($dir)) !== false)
{
	// we check if the file is a include file
	$extension = '.'.substr($file, -3);
	// and include once the file
	if ($extension == '.'.$phpEx)
	{
		include $plugins_path . $file;
	}
	elseif (file_exists($plugins_path.$file.'/'.$file.'.'.$phpEx))
	{ // way the way, whe check if the plugin is inside of a folder
		include $plugins_path.$file.'/'.$file.'.'.$phpEx;
	}
}

closedir($dir);

?>
