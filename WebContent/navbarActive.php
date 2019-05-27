<script>
$(document).ready(function() {
	
	var allProj;
	var last;
	var sec_last;
	$.when(
			//get all the projects for the given user
			$.ajax({
				type:'post',
				url:'user_projects.php',
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
			.append($('<form>').attr({'method':'post','action':'monitoring.php'})
    		.append($('<input>').attr({'name':'id','value':last.proj_id,'type':'hidden'}))
    		.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn'}).val(last.proj_name)))
    		  .appendTo('#list_proj');

			sec_last = allProj[allProj.length-2];

			$('<div>').attr({'class':'dropdown-item'})
			.append($('<form>').attr({'method':'post','action':'monitoring.php'})
    		.append($('<input>').attr({'name':'id','value':sec_last.proj_id,'type':'hidden'}))
    		.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn'}).val(sec_last.proj_name)))
    		  .appendTo('#list_proj');

			
			
		}else{
			
				$('<button>').attr({'class':'dropdown-item','onclick':'window.location="new_project.php"'}).text("New")
				.appendTo('#list_proj');
		}

		 
		

});
	$('<div>').attr({'class':'dropdown-divider'}).appendTo('#list_proj');
	 $('<div>').attr({'class':'dropdown-item'}).append($('<a>').attr({'href':'exampleProjects.php#active'}).
			 text('All projects')).appendTo('#list_proj');
	
});</script>
<header>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top">
			<a class="navbar-brand" href="exampleHome.php">BuildUp</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse"
				data-target="#navbarCollapse" aria-controls="navbarCollapse"
				aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="navbar-collapse collapse" id="navbarCollapse" style="">
				<ul class="navbar-nav mr-auto"> 
				
					<li class="nav-item active"><a class="nav-link"
						href="exampleProjects.php"> Projects</a></li>
						
					<li class="nav-item dropdown"><a
						class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
						role="button" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">Monitoring </a>
						
						<div class="dropdown-menu" aria-labelledby="navbarDropdown" id = "list_proj">
							
						<!-- 
							<div class="dropdown-item">
								<a href = "exampleProjects.php#active">All
								projects</a>
							</div>
								<div class="dropdown-divider"></div>
							 -->
						</div>
						</li>
						
					<li class="nav-item dropdown"><a
						class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
						role="button" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">Monitoring</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">Swiss Re</a> <a
								class="dropdown-item" href="#">IOC</a> <a class="dropdown-item"
								href="#">Unibx</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="exampleProjects.php#active">All
								projects</a>
						</div></li>
					<li class="nav-item"><a class="nav-link"
						href="MyProfile.php">My Profile</a></li>
					<li class="nav-item"><a class="nav-link"
						href="exampleAboutUs.php">About Us</a></li>

				</ul>
				<div class="form-inline mt-2 mt-md-0">
					<form>
						<input class="form-control mr-sm-2" type="search"
							placeholder="Search" aria-label="Search">
						<!-- button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button-->
						<a class="btn btn-light red" href="user_logout.php">Logout</a>
					</form>
				</div>
			</div>
		</nav>
	</header>
	<link rel="stylesheet" href="cover-styles.css">