<?php

require_once 'functions.php';

$con = mysql_connect("localhost", "root", "");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("ubicomp", $con);

$result = mysql_query("SELECT MIN(start_time) FROM arduino_readings");
$row = mysql_fetch_array($result);
$initialTime = strtotime($row[0]);
$finalTime = '2013-02-19 12:14:39';
$intervalWidth = '+2 minutes';

$result = mysql_query("SELECT * FROM arduino_readings");

echo '<table border=1>';
echo '<tr>';
echo '<th width=20%>Sensor Start Time</th>';
echo '<th width=20%>Sensor End Time</th>';
echo '<th width=20%>Interval Start Time</th>';
echo '<th width=20%>Interval Start Time</th>';
echo '<th width=20%>Sensor active Percentage</th>';
echo '</tr>';

while ($row = mysql_fetch_array($result))
{
    $startTime = $initialTime;
    $endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));


    while (strtotime($endTime) < strtotime($finalTime))
    {
        echo '<tr>';

        $startTime = date("Y-m-d H:i:s", $startTime);

        echo '<td>' . $row['start_time'] . '</td><td>' . $row['end_time'] . '</td>';
        echo '<td>' . $startTime . '</td><td>' . $endTime . '</td>';
        echo '<td>' . calculate_used_time($row['start_time'], $row['end_time'], $startTime, $endTime) . '</td>';

        $startTime = strtotime($endTime);
        $endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));

        echo '</tr>';
    }
}

mysql_close($con);


//SELECT `start_time`, `end_time`
//FROM arduino_readings
//GROUP BY MINUTE( `start_time` )
?>