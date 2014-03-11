<?php

function smarty_modifier_pd($date, $time = false)
{
    $result = '';

    if (!is_numeric($date))
        $date = strtotime($date);

    if (date('Y-m-d', $date) == date('Y-m-d', time()))
        $result .= 'today';
    elseif (date('Y-m-d', $date) == date('Y-m-d', strtotime('-1 day')))
        $result .= 'yesterday';
    elseif (date('Y-m-d', $date) == date('Y-m-d', strtotime('+1 day')))
        $result .= 'tomorrow';
    else
        $result .= date('d-m-Y', $date);

    if ($time)
        $result .= date(' H:i:s', $date);

    return $result;
}