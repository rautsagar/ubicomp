<?php include 'login_redirect.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>DBIT Ubicomp | Attendance Records</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Ubiquitous computing in a lab environment" />

<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="content-language" content="en-US" />


<link rel="stylesheet" type="text/css" href="css/styles2.css" media="screen" />
<link rel="stylesheet" href="css/menu.css" type="text/css" media="screen">
  
<script src="js/jquery-1.9.1.min.js"></script>
<script>
		$(document).ready(function(){
			$("#current_page_name").html("Attendance Records");
			$("#attendance_form").hide();
			$("#archived").on("click", function(event){
               $("#attendance_form").show('slow');
});
			
			
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
<script type="text/javascript">
	var day_number=1;
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
	
	function getDayNumber()
	{
		var subject=document.getElementById('subject').value;
		var batch=document.getElementById('batch').value;		
		
		$.ajax({
		    type: 'post',
		    url: 'getdaynumber.php',
		    data: 'subject='+subject+'&batch='+batch,
		    success: function(response) 
		    {			
			day_number=response;			
		}});		
	}
  </script>
  
  
  
  <!--Date picker content-->
  <link rel="stylesheet" href="jquery-ui-1.10.2.custom/css/smoothness/jquery-ui-1.10.2.custom.css" />
  <script src="jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
  <script src="jquery-ui-1.10.2.custom/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  
  
  <script>
  $(function() {
    
    $( "#datepicker" ).datepicker({
	  showAnim: "slideDown",
	  dateFormat:"yy-mm-dd",
      showButtonPanel: true,
	  changeMonth: true,
      changeYear: true,
	  minDate: "-1Y", 
	  maxDate: +0,
	beforeShowDay: function(date) {
        var day = date.getDay();
        return [(day==day_number)];
    }
	
    });
	
  });
  
      
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
<div class="clear"></div>

<div id="content_side">





</div>

<div id="content_wrapper">


 <div id="content">
<h3> Live attendance records</h3>
<h4>Here you can view the attendance of the practical session currently in progress.</h4>
<p>
To view the live attendance records, click on the link below
</p> 	
<a id="live_attendance" href="show_live_attendance.php">View live attendance</a>
<p>&nbsp;</p>
<hr />
<div id="archived"><h3><a href="#">Archived attendance records</a></h3></div>

<h4>Here you can view the attendance sheet of any practical session.</h4>
<p>
To view the attendance records of a practical session, fill out the fields below.
</p>

<div id="attendance_form">
     
      <form method="post" action="print_table.php"> 
        
		
		<p><label>Class:</label></p> 
        <p>
		<select autocomplete="off" id="classname" name="classname" onchange="getSubjects();">
		  <option selected="selected" value="">-------------Please select-------------</option>
		  <optgroup label="Computer Engineering">
			<option value="SE-Comps">S.E. Comps</option>
			<option value="TE-Comps">T.E. Comps</option>
			<option value="BE-Comps">B.E. Comps</option>
		  </optgroup>
		  <optgroup label="Electronics and Telecommunication">
			<option value="SE-EXTC">S.E. EXTC</option>
			<option value="TE-EXTC">T.E. EXTC</option>
			<option value="BE-EXTC">B.E. EXTC</option>
		  </optgroup>
		  <optgroup label="Information Technology">
			<option value="SE-IT">S.E. IT</option>
			<option value="TE-IT">T.E. IT</option>
			<option value="BE-IT">B.E. IT</option>
		  </optgroup>
		</select></p> 
		<p>&nbsp;</p>
		<p><label>Practical Subject:</label></p> 
        <p><select id="subject" name="subject" autocomplete="off" onchange="getBatches();">
			<option>Please first choose from above</option>
		</select></p>          
        <p>&nbsp;</p>
		<p><label>Batch:</label></p>  
        <p><select id="batch" name="batch" autocomplete="off" onchange="getDayNumber();">
			<option>Please first choose from above</option>
		</select></p>  
		<p>&nbsp;</p>
		<p><label>Date:</label></p>
        <p><input type="text" name="date"  id="datepicker" size="15" autocomplete="off"/></p> 
        <p>&nbsp;</p>
        <input type="submit" value="Submit" name="submit" />
		
		
      </form> 
</div>   

</div>

</div>
<? include 'footer.php'?>
</div>





</body>
</html>
