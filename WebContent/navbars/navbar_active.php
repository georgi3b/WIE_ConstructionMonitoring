<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['active_proj'])) {
        header("Location:../projects/projects.php#active");
        unset($_POST['active_proj']);
    } 
}
?>
<script>
$(document).ready(function() {
	
	var allProj;
	var last;
	var sec_last;
	$.when(
			//get all the projects for the given user
			$.ajax({
				type:'post',
				url:'../projects/user_projects_controller.php',
				dataType:'json',
				success: function(data, statusTxt, xmlht){
					allProj = data;
				}
		})
	).then(function(){
		if(allProj.length>=1){
			//add the last projects to a link in the navigation bar

			last = allProj[allProj.length-1];

			$('<div>').attr({'class':'dropdown-item'})
			.append($('<form>').attr({'method':'post','action':'../monitoring/monitoring.php'})
    		.append($('<input>').attr({'name':'id','value':last.proj_id,'type':'hidden'}))
    		.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn'}).val(last.proj_name)))
    		  .appendTo('#list_proj');

			if(allProj.length >=2 ){
			sec_last = allProj[allProj.length-2];

			$('<div>').attr({'class':'dropdown-item'})
			.append($('<form>').attr({'method':'post','action':'../monitoring/monitoring.php'})
    		.append($('<input>').attr({'name':'id','value':sec_last.proj_id,'type':'hidden'}))
    		.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn'}).val(sec_last.proj_name)))
    		  .appendTo('#list_proj');
			}
			
		}else{
			$('<div>').attr({'class':'dropdown-item'}).append(
				$('<input>').attr({'class':'dropdown-item','onclick':'window.location="../projects/new_project.php"'}).text("New"))
				.appendTo('#list_proj');
		}

	});

	//link to all the active projects
	$('<div>').attr({'class':'dropdown-item'}).
		append($('<form>').attr({'method':'post','action':'<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'})
    		.append($('<input>').attr({'name':'active_proj','type':'submit',
        		'value':'All projects','class':'btn'})))
	 .appendTo('#list_proj');
	 
	$('<div>').attr({'class':'dropdown-divider'}).appendTo('#list_proj');
});</script>
<header>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top">
		<a class="navbar-brand" href="../start/home.php">BuildUp</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse"
			data-target="#navbarCollapse" aria-controls="navbarCollapse"
			aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="navbar-collapse collapse" id="navbarCollapse" style="">
			<ul class="navbar-nav mr-auto">

				<li class="nav-item active"><a class="nav-link"
					href="../projects/projects.php"> Projects</a></li>

				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
					href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">Monitoring </a>

					<div class="dropdown-menu" aria-labelledby="navbarDropdown"
						id="list_proj">

						<!-- 
							<div class="dropdown-item">
								<a href = "../projects/projects.php#active">All
								projects</a>
							</div>
								<div class="dropdown-divider"></div>
							 -->
					</div></li>


				<li class="nav-item"><a class="nav-link" href="../user/user_profile.php">My
						Profile</a></li>
				<li class="nav-item"><a class="nav-link" href="../start/about_us.php">About
						Us</a></li>
						

			</ul>
			<div class="form-inline mt-2 mt-md-0">
				<form>
					<!-- button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button-->
					<a class="btn btn-light red" href="../user/user_logout_controller.php">Logout</a>
				</form>
			</div>
		</div>
	</nav>
</header>

<link rel="stylesheet" href="../styles/cover_styles.css">