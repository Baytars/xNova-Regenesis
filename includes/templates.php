<?php
/**
 * An ugly template parsing system for Xnova/Ugamela, a gift from DSC 7 for PHP4
 *
 * @version 3.0
 * @author Perberos
 * @contributor Kiki
 * @require plugins system 0.2
 * @copyright (c) Matsusoft Corporation
 * @license GPL 3 or any later version; http://www.gnu.org/copyleft/gpl.html
 */

if (!defined('INSIDE'))
{
	die('Hacking attemp');
}

/**
 * Read a file from template dir, getting as a string.
 */
function template_get($name, $ext = '.tpl')
{
	global $ugamela_root_path;
	// getting the file if exists
	$filename = $ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME .
		DIRECTORY_SEPARATOR . $name . $ext;

	($hook = get_hook('onTemplateGet')) ? eval($hook) : null;

	if (!file_exists($filename))
	{
		($hook = get_hook('onTemplateGetError')) ? eval($hook) : null;

		trigger_error('Missing template: ' . $filename);
	}
	else
	{
		return file_get_contents($filename);
	}
}

/**
 * This function parse an array in a template string
 */
function template_parse($string, $array)
{
	($hook = get_hook('onTemplateParse')) ? eval($hook) : null;
	// this functions is a simple to understand what do and hard to read
	return preg_replace('#(\{([a-z0-9\-_]*?)\})|(\{([a-z0-9\-_]*?)/\}(.+)\{/(['.
		'a-z0-9\-_]*?)\})#Ssie','((isset($array[\'\2\']))?$array[\'\2\']:((iss'.
		'et($array[\'\4\']) && is_array($array[\'\4\']))?template_parse_array('.
		'str_replace("\\\'","\'","\5"), $array[\'\4\']):\'\'));', $string);
}

/**
 * This function parse each array of array in a template string
 */
function template_parse_array($string, $array)
{
	($hook = get_hook('onTemplateParseArray')) ? eval($hook) : null;

	$tpl = '';

	foreach ($array as $arr)
	{
		$tpl .= template_parse($string, $arr);
	}

	return $tpl;
}

?>
