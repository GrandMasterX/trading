<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

function smarty_function_percent($params)
{
    $allocation = array(20, 25, 50, 70, 95);

    $result = Common::getCloserValue($params['value'], $allocation);

    return $result ? $result : 95;
}

?>