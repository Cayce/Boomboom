<?php
if (get_magic_quotes_gpc()) {
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

function e($text)
{
    return htmlspecialchars($text);
}

function redate_short($date)
{
    $date = explode(" ", $date);
    $ddate = explode("-", $date[0]);

    if (isset($date[1]))
        $date[1] = ' ' . $date[1];

    return("$ddate[2]/$ddate[1]/$ddate[0]");
}
?>