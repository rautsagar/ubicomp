<?php
session_start();

if (isset($_GET['session_name'])) 
{$_SESSION['session_name'] = $_GET['session_name'];
}else{$_SESSION['session_name'] = "2013-02-27"; }
//echo $_SESSION['session_name'];

include 'charts/openflashchart/php-ofc-library/open-flash-chart.php';
include 'db_conn.php';
include 'functions.php';

$result = mysql_query("SELECT MIN(start_time) FROM arduino_readings");
$row = mysql_fetch_array($result);
$initialTime = strtotime($row[0]);

$result = mysql_query("SELECT MAX(start_time) FROM arduino_readings");
$row = mysql_fetch_array($result);
$finalTime = strtotime($row[0]);

$intervalWidth = '+5 minutes';

$result = mysql_query('SELECT * FROM arduino_readings WHERE start_time LIKE "'.$_SESSION['session_name'].'%"');

$startTime = $initialTime;
$endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));

$data = array();
$x_labels = array();
while ($startTime < $finalTime)
{
    $used = 0;

    $startTime = date("Y-m-d H:i:s", $startTime);
    while ($row = mysql_fetch_array($result))
    {
        $used += calculate_used_time($row['start_time'], $row['end_time'], $startTime, $endTime);
    }

    $data[] = $used;
    $x_labels[] = date("H:i:s", strtotime($startTime));

//    echo '<tr>';
//    echo '<td>' . $startTime . '</td><td>' . $endTime . '</td>';
//    echo '<td>' . $used . '</td>';
//    echo '</tr>';


    $startTime = strtotime($endTime);
    $endTime = date("Y-m-d H:i:s", strtotime($intervalWidth, $startTime));

    mysql_data_seek($result, 0);
}
//print_r($data);
//print_r($x_labels);

foreach ($data as &$value)
{
    $value = intval($value, 10);
}
unset($value);

$title = new title("Sensor Readings");

$line_1_default_dot = new dot();
$line_1_default_dot->colour('#CC00FF');

$line_1 = new line();
$line_1->set_default_dot_style($line_1_default_dot);
$line_1->set_values($data);
$line_1->set_width(1);

$y = new y_axis();
$y->set_range(0, 100, 10);

$x = new x_axis();
$x_label = new x_axis_labels();
$x_label->set_steps( 2 );
$x_label->set_vertical();   
$x_label->set_labels( $x_labels );
$x->set_labels( $x_label );

$x_legend = new x_legend( 'Time' );
$x_legend->set_style( '{font-size: 20px; color: #778877}' );
$y_legend = new y_legend( 'Percentage' );
$y_legend->set_style( '{font-size: 20px; color: #778877}' );


$chart = new open_flash_chart();
$chart->set_title($title);
$chart->add_element($line_1);
$chart->set_x_axis($x);
$chart->set_x_legend($x_legend);
$chart->set_y_axis($y);
$chart->set_y_legend($y_legend);

echo $chart->toPrettyString();
?>