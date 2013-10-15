<?php
	
	include 'db_conn.php';
	
	
	if(isset($_COOKIE['uname'])){
		$user = $_COOKIE['uname'];
		$result = mysql_query("SELECT `id` , `name` FROM `faculty` WHERE `username` ='". $user."'");
		$row = mysql_fetch_array($result);
		echo $row[0];
		echo $row[1];
		
		
	}
	else {
		echo "!";
		echo "Please Login";
	}
	
    
?>