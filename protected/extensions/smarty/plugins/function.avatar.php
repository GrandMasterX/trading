<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

function smarty_function_avatar($params, $template)
{
    $width = $height = (isset($params['size'])) ? $params['size'] : '32';

    if (empty($params['image']))
        $image = '/images/no_avatar.png';
    else
        $image = $params['image'];

    return '<img src="' . $image . '" alt="" width="' . $width . '" height="' . $height . '" class="' . $params['class'] . '" />';
}

?>