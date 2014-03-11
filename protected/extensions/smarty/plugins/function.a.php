<?php

function smarty_function_a($params, &$smarty){

    if(!empty($params['params']) && is_array($params['params'])){
        $route = !empty($params['params'][0]) ? $params['params'][0] : $params['params']['route'];
        unset($params['params']['route']);
        unset($params['params'][0]);
        $params = $params['params'];
    }
    elseif(!empty($params['route'])) {
        $route = $params['route'];
        unset($params['route']);
    }
    else {
        throw new CException("Function 'route' parameter should be specified.");
    }

    return Yii::app()->createUrl(trim($route,'/'), $params);
}