<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>DBIT Ubicomp | Attendance Records</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Professional Portrait and Landscape Photography servicing Alabama and Mississippi." />
<meta name="keywords" content="ubiquitous computing, ubicomp, lab automation, ubicomp in a lab" />
<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="content-language" content="en-US" />


<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen" />
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script type="text/javascript">
	function getSubjects()
	{
		$("#subject").load("getsubjects.php?class="+$("#classname").val());
		//alert("Worked!");
	}
	function getBatches()
	{
		$("#batch").load("getbatches.php?subject="+$("#subject").val());
		//alert("Worked!");
	}
	/*$("#classname").change(function() {
		//$("#subject").load("getsubjects.php?choice="+$("#classname").val());
		//$("#subject").load("getsubjects.php?choice='BE Comps'");
		alert("Worked!");
	});*/
  </script>
  
  
  <!--Date picker content-->
  <link rel="stylesheet" href="jquery-ui-1.10.2.custom/css/smoothness/jquery-ui-1.10.2.custom.css" />
  <script src="jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
  <script src="jquery-ui-1.10.2.custom/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    //$( "#datepicker" ).datepicker();	
    $( "#datepicker" ).datepicker({
	  showAnim: "slideDown",
	  dateFormat:"yy-mm-dd",
      showButtonPanel: true,
	  changeMonth: true,
      changeYear: true,
	  minDate: "-1Y", 
	  maxDate: +0,
	  showWeek: true
    });
	//$( "#datepicker" ).datepicker( "dateFormat", "yy-mm-dd");
  });
  </script>
  
  
  
  
</head>

<body id="att">

<div id="container">

<div id="logo_wrapper">

<div id="logo">
<img src="images/site_logo.png" width="330" height="100" alt="Brad Young Photography" />
</div>
</div>

<div class="clear"></div>

<div id="content_side">

<div id="navigation">

<ul id="navlist">
<li><a href="index.php" id="homenav">Home</a></li>
<li><a href="" id="labusnav">Lab Usage Stats</a></li>
<li><a href="attendance_records.php" id="attnav">Attendance Records</a></li>
</ul>

</div>

<div id="quote">

<h5>Welcome back Administrator!</h5>

</div>

</div>

<div id="content_wrapper">

<div id="content">
	<?php
	
	$date=$_POST["date"];
	$classname=$_POST["classname"];
	$subject=$_POST["subject"];
	$batch=$_POST["batch"];
	
	echo "<p>Date: ".$date."</p>";
	echo "<p>Class: ".$classname."</p>";
	echo "<p>Practical Subject: ".$subject."</p>";
	echo "<p>Batch no.: ".$batch."</p>";
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

	echo "<p>Practical time duration: ".(($end_time-$start_time)*60)." minutes</p>";
	echo "<p>Present time threshold: ".$practical_time_threshold." minutes</p>";
	
	
	
	//$work_set= mysqli_query($con,"SELECT student_id, name, bluetooth_mac, (COUNT(capture_timestamp)*'$time_multiplier')-'$time_multiplier' AS minutes_present FROM (SELECT student_id,name,bluetooth_mac,capture_timestamp FROM attendance_records a,students s WHERE a.student_id=s.id AND practical_id='$prac_id' AND capture_timestamp LIKE '$date%') AS students_present GROUP BY student_id, name, bluetooth_mac");
	$result_set= mysqli_query($con,"SELECT student_id, roll_no,name, bluetooth_mac, (COUNT(capture_timestamp)*'$time_multiplier')-'$time_multiplier' AS minutes_present FROM 
											(SELECT student_id,roll_no,name,bluetooth_mac,capture_timestamp FROM attendance_records a,students s WHERE a.student_id=s.id AND 
											practical_id=(SELECT id FROM practical_sessions WHERE class='$classname' AND subject='$subject' AND batch_no='$batch') 
											AND capture_timestamp LIKE '$date%') AS students_present GROUP BY student_id, name, bluetooth_mac");
	
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
	
	
	mysqli_close($con);
?>
		<p>&nbsp;</p>
		<a href="attendance_records.php"><--Go back</a>
		<p>&nbsp;</p>
		
</div>

</div>

</div>

<div class="clear"></div>

<div id="footer_wrapper">

<div id="footer">
<p>Professional Portrait and Landscape Photography servicing Alabama and Mississippi. <a href="contact.html">Contact</a></p>
 <p>Copyright &copy; 2008 <a href="/index.html">Brad Young Photography</a>. Web Design by <a href="http://www.blueprintgroupe.com/">The Blueprint Groupe</a>. Validate <a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fwww.bradyoungphotography.com%2Fcss%2Fstyles.css">CSS</a> &nbsp;|&nbsp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a></p>
</div>

</div>

</body>
</html>


