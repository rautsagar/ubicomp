<?php include 'login_redirect.php'; ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset = "UTF-8" />	
<title> Lab Activity Graph</title>
<script src="js/jquery-1.9.1.min.js"></script>
<script>
var dateString = "2013-02-27"

$(document).ready(function(){
	$("#current_page_name").html(" Lab activity graph");
	$("#button").hide();		
	htStr="<p>Select a Lab first.</p>";
	$("#warnings").html(htStr);
	
  	$( "#datepicker" ).val("02/27/2013");
	
	


});

function setWarning(text){
	
	$("#warnings").html(text);
	
}

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

$(window).resize(function(){loadGraph()});

function loadGraph() {
	//$("#warnings").html("");
	setGraph();
	var width=$(window).width();
				var height=$(window).height();
				/*alert("height="+height+" width="+width);*/
				var htmlStr="<object style=\"visibility: visible;\" id=\"my_chart\" data=\"open-flash-chart.swf\" type=\"application/x-shockwave-flash\" width=\"";
				htmlStr +=width-150;
				htmlStr +="\" height=\"";
				htmlStr +=height/1.5;
				htmlStr +="\">";
				htmlStr +="<param value=\"data-file=data.php\" name=\"flashvars\"><param name=\"allowScriptAccess\" value=\"always\"><param name=\"movie\" value=\"open";
				htmlStr +="-flash-chart.swf\"><param name=\"quality\" value=\"high\"><param name=\"bgcolor\" value=\"#ffffff\"></object>";

	/*alert (htmlStr);*/

	$("#graph").html(htmlStr);
    
}

function setGraph(){
	$.ajax({
    type: 'get',
    url: 'data.php',
    data: 'session_name='+dateString,
    success: function(response) {
		if (response.indexOf("Warning") >= 0)
        {//alert(response);
			htStr="<p>No data for this date found</p>"
			setWarning(htStr);
			$("#graph").hide('fast');
			$("#button").show();
		}
		else {
		setWarning("Graph for: "+dateString);
		$("#graph").show('fast');
		$("#button").show('slow');
		}
    }
});
	
}

</script>

<!--Date picker content-->
  <link rel="stylesheet" href="jquery-ui-1.10.2.custom/css/smoothness/jquery-ui-1.10.2.custom.css" />
  <script src="jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
  <script src="jquery-ui-1.10.2.custom/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>

  $(function() {
  	
  	
    $( "#datepicker" ).datepicker({onSelect: function(dateText, inst) {
		
		//alert(dateText);
		var startDate = new Date(dateText);
		var month = startDate.getMonth();
		var day = startDate.getDate();
		var selMonth= (month < 10 ? "0" + (month+1) : month+1);
		var selDay= (day < 10 ? "0" + (day) : day);
        
		
		
		var selYear = startDate.getFullYear();
		dateString=(selYear+"-"+selMonth+"-"+selDay)
		loadGraph();
		
		//window.location.href = "graph.php?session_name="+dateString;
	}});	
   /* $( "#datepicker" ).datepicker({
	  onSelect: function(dateText, inst) { alert("Working"); }
	  showAnim: "slideDown",
	  dateFormat:"yy-mm-dd",
      showButtonPanel: true,
	  changeMonth: true,
      changeYear: true,
	  minDate: "-1Y", 
	  maxDate: +0,
	  showWeek: true
	
    });*/
	//$( "#datepicker" ).datepicker( "dateFormat", "yy-mm-dd");
  });
  



  </script>

<link rel="stylesheet" href="css/style_graph.css" type="text/css" media="screen"/>
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
					<li><a href="#"><span><img src="images/top2.png" /> Lab usage stats</span></a></li>
					
					<li><input type="text" size="8" name="date" value="Select date" id="datepicker"  autocomplete="off"/></li>
					<li><select autocomplete="off" onchange="loadGraph();" >
		  <option selected="selected" value="">Select Lab</option>
		  <optgroup label="Computer Engineering">
			<option value="SE-Comps">Project Lab</option>
			<option value="TE-Comps">Hardware Lab</option>
			<option value="BE-Comps">Multimedia Lab</option>
		  </optgroup>
		  <optgroup label="Electronics and Telecommunication">
			<option value="SE-EXTC">Raju Lab 1</option>
			<option value="TE-EXTC">Raju Lab 2</option>
			<option value="BE-EXTC">Raju Lab 3</option>
		  </optgroup>
		  <optgroup label="Information Technology">
			<option value="SE-IT">CSI Lab 1</option>
			<option value="TE-IT">CSI Lab 2</option>
			<option value="BE-IT">CSI Lab 3</option>
		  </optgroup>
		</select></li>
					
				</ul>

		</div>

		
		
	</div>
<div id="graph_container">
	<div id="warnings"></div>
	<div id="graph">
	</div>
</div>
<div id="button" onclick="loadGraph(); return false;"></div>
	<div id="graphFooter_wrapper">

		<? include 'footer.php'?>

	</div>
</body>
</html>