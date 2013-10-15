<?php include 'login_redirect.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>

	<title>DBIT Ubicomp | Home</title>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
	<meta http-equiv="content-language" content="en-US" />	
	

	<link rel="stylesheet" type="text/css" href="css/styles2.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/table.css" media="screen" />
	<link rel="stylesheet" href="css/menu.css" type="text/css" media="screen">
	<script src="js/jquery-1.9.1.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#current_page_name").html("Attendance results");
		});
		
		function del_cookie()
			{
				$.ajax({
				  type: 'post',
				  url: 'login.php',
				  data: 'del_cookie=True',
				  success: function(data){
				  	// alert(data);
                    window.location = "login.php";
  }
});
			}
	</script>

</head>
<body>
	<div id="header"><? include 'topbar.php'?></div>
	<div id="container">
		<div id="menu_container">

				<ul id="nav">
					<li><a href="index.php"><img src="images/home.png" /> Home</a></li>
					<li><a href="attendance_records.php"><span><img src="images/top1.png" /> Attendance records</span></a></li>
					<li><a href="graph.php"><span><img src="images/top2.png" /> Lab usage stats</span></a></li>
					
				</ul>

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
	
	
	$result_set= mysqli_query($con,"SELECT student_id, roll_no,name, bluetooth_mac, (COUNT(capture_timestamp)*'$time_multiplier')-'$time_multiplier' AS minutes_present FROM 
											(SELECT student_id,roll_no,name,bluetooth_mac,capture_timestamp FROM attendance_records a,students s WHERE a.student_id=s.id AND 
											practical_id=(SELECT id FROM practical_sessions WHERE class='$classname' AND subject='$subject' AND batch_no='$batch') 
											AND capture_timestamp LIKE '$date%') AS students_present GROUP BY roll_no") or die("Error in query: ".mysqli_error());
	
	
	$num_results = mysqli_num_rows($result_set); 
	if($num_results==0)
	{
		echo "There are no attendance records to display. This could be due to one of the following reasons: <br />
		<ul>
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
		echo "<table cellspacing='0'>
		<tr>
		<th >Student Name</th>
		<th>Roll no.</th>
		<th>Student ID</th>
		<th>Bluetooth MAC</th>
		<th>Minutes Present</th>
		<th>Attendance Remark</th>
		</tr>";
		
        $counter = 1;
		while($row = mysqli_fetch_array($result_set))
		{
			
		if($counter%2==0){
		  echo "<tr>";
		  echo "<th class='spec'>" . $row['name'] . "</th>";
		  echo "<td>" . $row['roll_no'] . "</td>";
		  echo "<td>" . $row['student_id'] . "</td>";
		  echo "<td>" . $row['bluetooth_mac'] . "</td>";
		  echo "<td>" . $row['minutes_present'] . "</td>";
		  if($row['minutes_present']>$practical_time_threshold)
			echo "<td>Present</td>";
		  else if($row['minutes_present']>30)
			echo "<td>Insufficient time</td>";
		  else echo "<td>Absent</td>";	  
		  echo "</tr>";
		}
			else{
		  echo "<tr>";
		  echo "<th class='specalt'>" . $row['name'] . "</th>";
		  echo "<td class='alt'>" . $row['roll_no'] . "</td>";
		  echo "<td class='alt'>" . $row['student_id'] . "</td>";
		  echo "<td class='alt'>" . $row['bluetooth_mac'] . "</td>";
		  echo "<td class='alt'>" . $row['minutes_present'] . "</td>";
		  if($row['minutes_present']>$practical_time_threshold)
			echo "<td class='alt'>Present</td>";
		  else if($row['minutes_present']>30)
			echo "<td class='alt'>Insufficient time</td>";
		  else echo "<td class='alt'>Absent</td>";	  
		  echo "</tr>";
			}
		$counter++;
 		}
		echo "</table>";
	}
	
	
	
	
	mysqli_close($con);
?>
		<p>&nbsp;</p>
		<a id="back" href="attendance_records.php">Go back</a>
		<p>&nbsp;</p>
			</div>
	
		</div>
	<? include 'footer.php'?>
	</div>

</body>
</html>