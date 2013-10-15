<?php
	header('Content-type: text/html; charset=utf-8');
	$username = "root";
	$password = "";
	$hostname = "localhost";
	
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	$selected = mysql_select_db("ubicomp", $dbhandle) or die("Could not select examples");
	$subject = mysql_real_escape_string($_GET['subject']);
	//$choice = $_GET['choice'];
	//echo $choice;
	
	$query = "SELECT * FROM practical_sessions WHERE subject='$subject'";
	
	$result = mysql_query($query);
		echo "<option value=''>---Select---</option>";
	while ($row = mysql_fetch_array($result)) {
		//echo $row['subject'];
   		echo "<option value='". $row['batch_no'] ."'>" . $row['batch_no'] . "</option>";
		//echo "<option>" . $row{'subject'} . "</option>";
		//echo <option value="' . $result['id'] . '">' . $result['subject'] . '</option>';
	}
?>