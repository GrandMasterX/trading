<?php

function smarty_modifier_timeago($date)
{
    $timeAgo = new TimeAgo();

    return $timeAgo->inWords($date);
}