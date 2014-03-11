<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

function smarty_function_progress($params)
{
    if ($params['type'] == 'date')
    {
        $current = time();

        if ($params['end'] < $params['start'])
            return 0;

        if ($params['action'] == 'progress')
            return ($current < strtotime($params['end'])) ?
                (($params['end'] != $params['start'] && strtotime($params['start']) < $current) ? round(($current - strtotime($params['start'])) / (strtotime($params['end']) - strtotime($params['start'])) * 100) : 0) :
                100;
        else if ($params['action'] == 'percent')
            return ($params['end'] != $params['start'] && strtotime($params['start']) < $current) ? round(($current - strtotime($params['start'])) / (strtotime($params['end']) - strtotime($params['start'])) * 100) : 0;
        else
            return ($current <= strtotime($params['end'])) ? ceil((strtotime($params['end']) - $current) / (3600 * 24)) : 0;
    }
    else if ($params['type'] == 'value')
    {
        if ($params['action'] == 'progress')
            return ($params['current'] < $params['end']) ?
                (($params['end'] != $params['start']) ? round(($params['current'] - $params['start']) / ($params['end'] - $params['start']) * 100) : 0) :
                100;
        else if ($params['action'] == 'percent')
            return ($params['end'] != $params['start']) ? round(($params['current'] - $params['start']) / ($params['end'] - $params['start']) * 100) : 0;
        else
            return ($params['current'] <= $params['end']) ? ($params['end'] - $params['current']) : 0;
    }

    return false;
}

?>