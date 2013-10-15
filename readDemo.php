<?php

require_once './db_conn.php';

$log = file('data_dumps/log27-2.txt', true);

$startTime = '';
$endTime = '';
$started = 0;
foreach ($log as &$line)
{
    //echo $line.'<br />';
    if (strpos($line, 'Started:') !== false && $started == 0)
    {
        $started = 1;
        $startTime = substr($line, -20);
        echo $startTime . '<br />';
        continue;
    } else if (strpos($line, 'Ended:') !== false && $started == 1)
    {
        $started = 0;
        $endTime = substr($line, -20);
        echo $endTime . '<br />';

        $result = mysql_query("INSERT INTO arduino_readings (start_time, end_time) VALUES ('" . $startTime . "','" . $endTime . "')");
    }
    $startTime = '';
    $endTime = '';
}


?>
