<!DOCTYPE html >
<html lang="en" >
<head>

	<title>DBIT Ubicomp | Home</title>

	
	<script src="js/jquery-1.9.1.min.js"></script>
	<script>
		$.ajax({
    type: 'post',
    url: 'get_user_data.php',
    data: 'uname=allan',
    success: function(response) {
		//alert(response);
		var id = response.substring(0,1);
		var name = response.substring(1);
		//alert(id+name);
		
			
		}
		
});
	</script>

	<link rel="stylesheet" type="text/css" href="css/styles2.css" media="screen" />
	
	<link rel="stylesheet" href="css/menu.css" type="text/css" media="screen">

</head>
<body>
	<div id="header"><?php include 'topbar.php'?></div>
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
				This is where you can view the lab usage statistics and view the attendance records.
				</p>
				<img src="images/graphs.jpg" />
				<p>
				Navigate to the respective web pages.
				</p>
			</div>
	
		</div>
	<? include 'footer.php'?>
	</div>

</body>
</html>