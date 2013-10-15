<?
if(isset($_POST['del_cookie'])){
	//echo "entered if";
	setcookie('uname','',time()-3600,'/');
	
	
}


?>
<!DOCTYPE html >
<html lang="en" >
<head>

	<title>DBIT Ubicomp | Home</title>

	<meta charset="UTF-8" />
	<meta name="description" content="Ubiquitous computing in a lab environment" />
	<meta name="keywords" content="ubiquitous computing, ubicomp, lab automation, ubicomp in a lab" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="content-language" content="en-US" />
	<meta name="copyright" content="Copyright 2013 Sagar Raut. All rights reserved." />
	
	<script src="js/jquery-1.9.1.min.js"></script>
	<script>
		$(document).ready(function(){
	$("#current_page_name").html(" Login page");
	$("#user_icon").hide();


});

	</script>

	<link rel="stylesheet" type="text/css" href="css/styles2.css" media="screen" />
	
	<link rel="stylesheet" href="css/menu.css" type="text/css" media="screen">

</head>
<body>
	<div id="header"><? include 'topbar.php'?></div>
	<div id="container">
		<div id="login-top">
							
			</div>
		<div id="LoginContent_wrapper">
			<form name="login_credentials" method="post" action="authentication.php">
				<table align="center">
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="passwd" /></td>
					</tr>
					<tr><td colspan="2" align="center"><input type="Submit" name="SubmitBtn" value="Login" /></td></tr>
				</table>
			
			</form>
		</div>
	<? include 'footer.php'?>
	</div>

</body>
</html>