<?php

    // Turning off magic quotes
function magic_quotes_turn_off()
{
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

    // Making htmlspecialchars function be shorter
function e($str)
{
    return(htmlspecialchars($str));
}

function redate_short($date)
{
    $date = explode(" ", $date);
    $ddate = explode("-", $date[0]);

    if (isset($date[1]))
        $date[1] = ' ' . $date[1];

    return("$ddate[2]/$ddate[1]/$ddate[0]");
}