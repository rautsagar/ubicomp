<?php include 'login_redirect.php'; ?>
<!DOCTYPE html >
<html lang="en" >
<head>

	<title>DBIT Ubicomp | Home</title>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="Ubiquitous computing in a lab environment" />
	<meta name="keywords" content="ubiquitous computing, ubicomp, lab automation, ubicomp in a lab" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="content-language" content="en-US" />
	
	<script src="js/jquery-1.9.1.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#current_page_name").html(" Home");
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

	<link rel="stylesheet" type="text/css" href="css/styles2.css" media="screen" />
	
	<link rel="stylesheet" href="css/menu.css" type="text/css" media="screen">

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
				<h1>Ubicomp Backend</h1>
				<p>
				UbiComp is a cheap attendance automation and power saving solution deployed
        in the laboratories of Don Bosco Institute of Technology, Kurla.</p><p> It aims to rid teachers and students alike of the 
        menial tasks of attendance and the associated paperwork and keep the focus on the teaching-learning process during a 
        practical session.</p>
        <p>This website is a client meant for the faculty members of DBIT to check attendance records of past 
        practical sessions as well as view the list of students present in a live practical session.
    
				</p>
				<img src="images/graphs.jpg" />
				
			</div>
	
		</div>
	<? include 'footer.php'?>
	</div>

</body>
</html>
