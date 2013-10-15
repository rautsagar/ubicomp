<?php

include '../php-ofc-library/open-flash-chart.php';

include '../data_con.php';

$result = mysql_query("select * from bha_rate");

$data = array();
$max = 0;
while($row = mysql_fetch_array($result))
{
  $data[] = $row['stock_val'];
}

foreach ($data as &$value) {
    $value = intval($value,10);
}
unset($value);

$title = new title( "Bharati Airtel" );

$line_1_default_dot = new dot();
$line_1_default_dot->colour('#CC00FF');

$line_1 = new line();
$line_1->set_default_dot_style($line_1_default_dot);
$line_1->set_values( $data );
$line_1->set_width( 1 );




$y = new y_axis();
$y->set_range( 300, 600, 50 );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $line_1 );
$chart->set_y_axis( $y );

echo $chart->toPrettyString();


?>