<body bgcolor="#FFFFFF">
<font color="BLACK">
<?php
	
	$date=$_GET["date"];
	$classname=$_GET["classname"];
	$subject=$_GET["subject"];
	$batch=$_GET["batch"];
	
	
	$host='localhost';
	$uname='root';
	$pwd='';
	$db='ubicomp';
	$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
	

	$prac_id_query = mysql_query("SELECT subject,start_time,end_time FROM practical_sessions WHERE class='$classname' AND subject='$subject' AND batch_no='$batch'");
	$prac_row = mysql_fetch_array($prac_id_query);
	$prac_subject=$prac_row['subject'];
	$start_time=$prac_row['start_time'];
	$end_time=$prac_row['end_time'];	
	
	$time_multiplier=1;
	if($prac_subject=='Project')
		$practical_time_threshold=($end_time-$start_time)*60*0.60;		//Student should be present for a minimum of 60% of the project duration to be marked present
	else
		$practical_time_threshold=($end_time-$start_time)*60*0.75;		//Student should be present for a minimum of 75% of the practical duration to be marked present	
	
	
	$result_set= mysql_query("SELECT student_id, roll_no,name, bluetooth_mac, (COUNT(capture_timestamp)*'$time_multiplier')-'$time_multiplier' AS minutes_present FROM 
											(SELECT student_id,roll_no,name,bluetooth_mac,capture_timestamp FROM attendance_records a,students s WHERE a.student_id=s.id AND 
											practical_id=(SELECT id FROM practical_sessions WHERE class='$classname' AND subject='$subject' AND batch_no='$batch') 
											AND capture_timestamp LIKE '$date%') AS students_present GROUP BY roll_no") or die("Error in query: ".mysql_error());
	
	
	$num_results = mysql_num_rows($result_set); 
	if($num_results==0)
	{
		echo "There are no attendance records to display. This could be due to one of the following reasons: <br />
		<ul>
					<li>You selected the wrong combination of class, subject and batch number.</li>
					<li>The day you selected was not a working day.</li>
					<li>You selected a day other than the one the practical is usually held on.</li>
					<li>The practicals were not held for some other reason.</li>
					
				</ul>";
		
	}
	else
	{
		echo "<p>Date: ".$date."</p>";
		echo "<p>Class: ".$classname."</p>";
		echo "<p>Practical Subject: ".$subject."</p>";
		echo "<p>Batch no.: ".$batch."</p>";
		echo "<p>Practical time duration: ".(($end_time-$start_time)*60)." minutes</p>";
		echo "<p>Present time threshold: ".$practical_time_threshold." minutes</p>";
		echo "<table border='1' cellpadding='10' style='color: #000000; border-style:solid; border-color:#000000; border-width: 1px 1px 1px 1px; border-spacing: 0; border-collapse: collapse;'>
		<tr>
		<th>ID</th>
		<th>Roll no.</th>
		<th>Student Name</th>
		<!--<th>Bluetooth MAC</th>-->
		<th>Minutes Present</th>
		<th>Attendance Remark</th>
		</tr>";

		while($row = mysql_fetch_array($result_set))
		{
		  echo "<tr>";
		  echo "<td>" . $row['student_id'] . "</td>";
		  echo "<td>" . $row['roll_no'] . "</td>";
		  echo "<td>" . $row['name'] . "</td>";
		  //echo "<td>" . $row['bluetooth_mac'] . "</td>";
		  echo "<td>" . $row['minutes_present'] . "</td>";
		  if($row['minutes_present']>$practical_time_threshold)
			echo "<td>Present</td>";
		  else if($row['minutes_present']>30)
			echo "<td>Insufficient time</td>";
		  else echo "<td>Absent</td>";	  
		  echo "</tr>";
		}
		echo "</table>";
	}	
	mysql_close($con);
?>
</font>
</body>