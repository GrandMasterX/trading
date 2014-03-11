<?php

function smarty_modifier_json2table($json, $class = '', $padding = 15)
{
    if (!is_array($json))
        $json = json_decode($json, true);

    $result = '<table class="'.$class.'">';
    $result .= smarty_modifier_json2table_rec($json, $padding);
    $result .='</table>';

    return $result;
}

function smarty_modifier_json2table_rec($array, $padding, $level = 1)
{
    $result = '';
    if (!is_array($array))
        return $result;

    foreach ($array as $key => $item) {

        if (is_array($item)) {
            $result .= '<tr><th colspan="2" style="padding-left: '.($padding * $level).'px">'.htmlspecialchars($key).'</th></tr>';
            $result .= smarty_modifier_json2table_rec($item, $padding, $level+1);
            continue;
        }

        $result .= '<tr><th style="padding-left: '.($padding * $level).'px">'.htmlspecialchars($key).'</th><td>'.htmlspecialchars($item).'</td></tr>';
    }

    return $result;
}