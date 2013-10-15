<?php

require_once 'functions.php';
require_once 'db_conn.php';

$result = mysql_query("SELECT MIN(start_time) FROM arduino_readings");
$row = mysql_fetch_array($result);
$initialTime = strtotime($row[0]);

$result = mysql_query("SELECT MAX(start_time) FROM arduino_readings");
$row = mysql_fetch_array($result);
$finalTime = strtotime($row[0]);

$intervalWidth = '+10 minutes';

$result = mysql_query("SELECT * FROM arduino_readings");
echo '<table border=1>';
echo '<tr>';
echo '<th width=20%>Interval Start Time</th>';
echo '<th width=20%>Interval Start Time</th>';
echo '<th width=20%>Sensor active Percentage</th>';
echo '</tr>';

$startTime = $initialTime;
$endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));




//echo $startTime.'<br />';
//echo $endTime.'<br />';
//echo $initialTime.'<br />';
//echo $finalTime.'<br />';


while ($startTime < $finalTime)
{
    $used = 0;

    $startTime = date("Y-m-d H:i:s", $startTime);
    while ($row = mysql_fetch_array($result))
    {
        $used += calculate_used_time($row['start_time'], $row['end_time'], $startTime, $endTime);

//        echo '<tr>';
//        echo '<td>' . $row['start_time'] . '</td><td>' . $row['end_time'] . '</td>';
//        echo '<td>' . $used . '</td>';
//        echo '</tr>';
    }

//    $startTime = date("Y-m-d H:i:s", $startTime);

    echo '<tr>';
    echo '<td>' . $startTime . '</td><td>' . $endTime . '</td>';
    echo '<td>' . $used . '</td>';
    echo '</tr>';


    $startTime = strtotime($endTime);
    $endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));

    mysql_data_seek($result, 0);
}



//while ($row = mysql_fetch_array($result))
//{
//    $startTime = $initialTime;
//    $endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));
//
//
//    while (strtotime($endTime) < strtotime($finalTime))
//    {
//        echo '<tr>';
//
//        $startTime = date("Y-m-d H:i:s", $startTime);
//
//        echo '<td>' . $row['start_time'] . '</td><td>' . $row['end_time'] . '</td>';
//        echo '<td>' . $startTime . '</td><td>' . $endTime . '</td>';
//        echo '<td>' . calculate_used_time($row['start_time'], $row['end_time'], $startTime, $endTime) . '</td>';
//
//        $startTime = strtotime($endTime);
//        $endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));
//
//        echo '</tr>';
//    }
//}
mysql_close($con);
?>