<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsModifier
 */
/**
 * Smarty implode modifier plugin
 * Type:     modifier
 * Name:     implode
 * Purpose:  fixes Passing glue string after array is deprecated keeping the same syntax
 *
 * @link   
 * @author blaat
 *
 * @param string $array
 * @param string $glue.
 *
 * @return string
 */
function smarty_modifier_implode($array, $glue = '')
{
	return implode($glue, $array);
}
