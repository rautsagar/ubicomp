<meta http-equiv="refresh" content="60;url=live_attendance.php">
<?php
	if(isset($_COOKIE['uname']))
	{
		date_default_timezone_set ("Asia/Calcutta");
		$username=$_COOKIE['uname'];
		
		include('db_conn.php');
		$faculty_result_set= mysql_query("SELECT name FROM faculty WHERE username='$username'") or die("Error in query: ".mysql_error());
	
		$row = mysql_fetch_array($faculty_result_set);
		
		$faculty_member=$row['name'];		
		$current_date=date('Y-m-d');
		$current_time=date('G:i:s');
		$day_number=date('w');
		$time_multiplier=1;
		
		$practical_result_set= mysql_query("SELECT * FROM practical_sessions WHERE faculty_incharge='$faculty_member' AND day='$day_number' AND '$current_time' BETWEEN start_time AND end_time") or die("Error in query: ".mysql_error());
		
		$prac_row = mysql_fetch_array($practical_result_set);
		$prac_id=$prac_row['id'];
		$prac_subject=$prac_row['subject'];
		$prac_class=$prac_row['class'];
		$prac_batch_no=$prac_row['batch_no'];
		$start_time=$prac_row['start_time'];
		$end_time=$prac_row['end_time'];
		
		if($prac_subject=='Project')
		$practical_time_threshold=($end_time-$start_time)*60*0.60;		//Student should be present for a minimum of 60% of the project duration to be marked present
	else
		$practical_time_threshold=($end_time-$start_time)*60*0.75;		//Student should be present for a minimum of 75% of the practical duration to be marked present		
		
		
		$result_set = mysql_query("SELECT student_id, roll_no,name, bluetooth_mac, (COUNT(capture_timestamp)*'$time_multiplier')-'$time_multiplier' AS minutes_present FROM(SELECT student_id,roll_no,name,bluetooth_mac,capture_timestamp FROM attendance_records a,students s WHERE a.student_id=s.id AND practical_id = (SELECT id FROM practical_sessions WHERE faculty_incharge = '$faculty_member' AND DAY ='$day_number' AND '$current_time' BETWEEN start_time AND end_time) AND capture_timestamp LIKE '$current_date%') AS students_present GROUP BY roll_no;") or die("Error in query: ".mysql_error());
		$num_results = mysql_num_rows($result_set); 
		if($num_results==0)
		{
			echo "You do not have any practical sessions currently in progress.";
		}
		else
		{
			echo "<h3>Live session details</h3>";
			
			echo "<p>Class: ".$prac_class."</p>";
			echo "<p>Practical Subject: ".$prac_subject."</p>";
			echo "<p>Batch no.: ".$prac_batch_no."</p>";
			echo "<p>Practical time duration: ".(($end_time-$start_time)*60)." minutes</p>";
			echo "<p>Present time threshold: ".$practical_time_threshold." minutes</p>";
			echo "<table border='1'>
			<tr>
			<th>Student ID</th>
			<th>Roll no.</th>
			<th>Student Name</th>
			<th>Bluetooth MAC</th>
			<th>Minutes Present</th>			
			</tr>";

			while($row = mysql_fetch_array($result_set))
			{
			  echo "<tr>";
			  echo "<td>" . $row['student_id'] . "</td>";
			  echo "<td>" . $row['roll_no'] . "</td>";
			  echo "<td>" . $row['name'] . "</td>";
			  echo "<td>" . $row['bluetooth_mac'] . "</td>";
			  echo "<td>" . $row['minutes_present'] . "</td>";			   
			  echo "</tr>";
			}
			echo "</table>";
		}
		
	}
	else
	{
		header('Location: login.php');	
	}

	
?>
