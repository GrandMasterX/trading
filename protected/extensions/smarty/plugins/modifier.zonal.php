<?php

function smarty_modifier_zonal($date)
{
    $margin=0;

    $_user = User::model()->findByPk(Yii::app()->user->id);

    if($_user->profile->timezone)
        $margin = $_user->profile->timezone;

    return date('Y-m-d  H:i:s', strtotime($date) - $margin * 60 * 60 - date('Z'));
}

//return date format
//2013-10-16 16:08:06