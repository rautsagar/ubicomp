<div id="topbar">
	<script>
		$.ajax({
    type: 'post',
    url: 'get_user_data.php',
    success: function(response) {
		//alert(response);
		var id = response.substring(0,1);
		var name = response.substring(1);
		//alert(id+name);
		$("#user_name").html("Welcome "+name);
		}
		
	});
	</script>
<div id="current_page_name"></div>
<div id="user_area">
	<div id="user_name"></div>
	<button  id="user_icon" type="button"   onclick="del_cookie();">
    </button>
</div>

</div>