<?php

function smarty_modifier_text2li($text)
{
    $result = '';
    $items = explode("\n", $text);
    foreach ($items as $item) {
        $item = trim($item);
        if (!empty($item))
            $result .= '<li>'.htmlspecialchars($item).'</li>';
    }

    return $result;
}