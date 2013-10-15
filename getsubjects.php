<?php
	header('Content-type: text/html; charset=utf-8');
	$username = "root";
	$password = "";
	$hostname = "localhost";
	
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	$selected = mysql_select_db("ubicomp", $dbhandle) or die("Could not select examples");
	$class = mysql_real_escape_string($_GET['class']);
	//$choice = $_GET['choice'];
	//echo $choice;
	
	$query = "SELECT DISTINCT subject FROM practical_sessions WHERE class='$class'";
	
	$result = mysql_query($query);
		echo "<option value=''>---Select---</option>";
	while ($row = mysql_fetch_array($result)) {
		//echo $row['subject'];
   		echo "<option value='". $row['subject'] ."'>" . $row['subject'] . "</option>";
		//echo "<option>" . $row{'subject'} . "</option>";
		//echo <option value="' . $result['id'] . '">' . $result['subject'] . '</option>';
	}
?>