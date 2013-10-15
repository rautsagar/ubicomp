<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>DBIT Ubicomp | Attendance Records</title>

<meta charset="UTF-8" />
<meta http-equiv="content-language" content="en-US" />
  
  
</head>

<body id="att">

<div id="container">

<div id="content_side">

<div id="navigation">

<ul id="navlist">
<li><a href="index.php" id="homenav">Home</a></li>
<li><a href="" id="labusnav">Lab Usage Stats</a></li>
<li><a href="attendance_records.php" id="attnav">Attendance Records</a></li>
</ul>

</div>

</div>

<div id="content_wrapper">

<div id="content">
	<?php
	
	$date=$_POST["date"];
	$classname=$_POST["classname"];
	$subject=$_POST["subject"];
	$batch=$_POST["batch"];
	
	
	$con=mysqli_connect("localhost","root","","ubicomp");

	// Check connection
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}	

	$prac_id_query = mysqli_query($con,"SELECT subject,start_time,end_time FROM practical_sessions WHERE class='$classname' AND subject='$subject' AND batch_no='$batch'");
	$prac_row = mysqli_fetch_array($prac_id_query);
	$prac_subject=$prac_row['subject'];
	$start_time=$prac_row['start_time'];
	$end_time=$prac_row['end_time'];	
	
	$time_multiplier=1;
	if($prac_subject=='Project')
		$practical_time_threshold=($end_time-$start_time)*60*0.60;		//Student should be present for a minimum of 60% of the project duration to be marked present
	else
		$practical_time_threshold=($end_time-$start_time)*60*0.75;		//Student should be present for a minimum of 75% of the practical duration to be marked present

		
	
	$query = "SELECT student_id, roll_no,name, bluetooth_mac, (COUNT(capture_timestamp)*'$time_multiplier')-'$time_multiplier' AS minutes_present FROM 
											(SELECT student_id,roll_no,name,bluetooth_mac,capture_timestamp FROM attendance_records a,students s WHERE a.student_id=s.id AND 
											practical_id=(SELECT id FROM practical_sessions WHERE class='$classname' AND subject='$subject' AND batch_no='$batch') 
											AND capture_timestamp LIKE '$date%') AS students_present GROUP BY roll_no";
	$result_set= mysql_query($con,$query) or die("Error in query: ".mysql_error());
	
	
	$num_results = mysqli_num_rows($result_set); 


	if($num_results==0)
	{
		echo "No attendance records to display.";
		
	}
	else
	{
		echo "<p>Date: ".$date."</p>";
		echo "<p>Class: ".$classname."</p>";
		echo "<p>Practical Subject: ".$subject."</p>";
		echo "<p>Batch no.: ".$batch."</p>";
		echo "<p>Practical time duration: ".(($end_time-$start_time)*60)." minutes</p>";
		echo "<p>Present time threshold: ".$practical_time_threshold." minutes</p>";
		//$result_set = mysqli_query($con,"SELECT student_id,capture_timestamp FROM '$work_set'");
		echo "<table border='1'>
		<tr>
		<th>Student ID</th>
		<th>Roll no.</th>
		<th>Student Name</th>
		<th>Bluetooth MAC</th>
		<th>Minutes Present</th>
		<th>Attendance Remark</th>
		</tr>";

		while($row = mysqli_fetch_array($result_set))
		{
		  echo "<tr>";
		  echo "<td>" . $row['student_id'] . "</td>";
		  echo "<td>" . $row['roll_no'] . "</td>";
		  echo "<td>" . $row['name'] . "</td>";
		  echo "<td>" . $row['bluetooth_mac'] . "</td>";
		  echo "<td>" . $row['minutes_present'] . "</td>";
		  if($row['minutes_present']>$practical_time_threshold)
			echo "<td>Present</td>";
		  else if($row['minutes_present']>30)
		    echo "<td>Insufficient time</td>";
		  else echo "<td>Absent</td>";
		  //echo "<td>" . $row['capture_timestamp'] . "</td>";	 
		  echo "</tr>";
		}
		echo "</table>";
	}	
	
	
	mysqli_close($con);
?>
		<p>&nbsp;</p>
		<a href="attendance_records.php"><--Go back</a>
		<p>&nbsp;</p>
		
</div>

</div>

</div>

</body>
</html>


