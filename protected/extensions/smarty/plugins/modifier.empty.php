<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */


function smarty_modifier_empty($string, $text=null)
{
    if (empty($string))
        return $text ? $text : 'Empty text';
    else
        return $string;
}

?>