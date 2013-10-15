<?php
	header('Content-type: text/html; charset=utf-8');
	$username = "root";
	$password = "";
	$hostname = "localhost";
	
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	$selected = mysql_select_db("ubicomp", $dbhandle) or die("Could not select examples");
	
	$subject = mysql_real_escape_string($_POST['subject']);
	$batch = mysql_real_escape_string($_POST['batch']);
	//$choice = $_GET['choice'];
	//echo $choice;
	
	$query = "SELECT day FROM practical_sessions WHERE subject='$subject' AND batch_no='$batch'";
	
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$day_number=$row['day'];
	echo $day_number;
?>
