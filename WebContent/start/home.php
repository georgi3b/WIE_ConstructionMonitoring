<?php 
session_start();

if(isset($_SESSION['user_id'])){
    $u_mail = $_SESSION['user_id']->u_mail;
}else{
    header("location:start/index.php");
}


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="Anna Debiasi, Georgiana Bud">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../cover-functions.js"></script>
<script>
$(document).ready(function() {
	
	//var json_proj = ?php echo json_encode($list_proj);?>;
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
		//if the user has already created at least two projects
		if(allProj.length>=1){
		
    		last = allProj[allProj.length-1];
    		//alert(last);
    		$('<h1>').attr({'value':'Project ' + last.proj_id})
    					.text('Project ' + last.proj_id + ": " + last.proj_name).appendTo('#last_proj');
    		$('<p>').text(last.description).appendTo('#last_proj');
    		$('<form>').attr({'method':'post','action':'projects/project_info.php'})
    		.append($('<input>').attr({'name':'id','value':last.proj_id,'type':'hidden'}))
    		.append($('<input>').attr({'name':'info','type': 'submit','class':'btn btn-primary'}).val("more info"))
    		  .appendTo('#last_proj');
    
    		if(allProj.length>=2){
        		sec_last = allProj[allProj.length-2];
        		//alert(last);
        
        		$('<h1>').attr({'value':'Project ' + sec_last.proj_id})
        					.text('Project ' + sec_last.proj_id + ": " + sec_last.proj_name).appendTo('#sec_last_proj');
        
        		$('<p>').text(sec_last.description).appendTo('#sec_last_proj');
        
        		$('<form>').attr({'method':'post','action':'projects/project_info.php'})
        		.append($('<input>').attr({'name':'id','value':sec_last.proj_id,'type':'hidden'}))
        		.append($('<input>').attr({'name':'info','type': 'submit','class':'btn btn-primary'}).val("more info"))
        		  .appendTo('#sec_last_proj');
    		} else {
    			$('<h1>').text('Please create a project').appendTo('#sec_last_proj');
        	}
    	} else {
    		$('<h1>').text('Please create a project').appendTo('#last_proj');
    		$('<h1>').text('Please create a project').appendTo('#sec_last_proj');
        }
	});

	//var user = '?php echo $u_mail;?>';			

});
</script>
<link rel="stylesheet" href="../styles/style.css">
<title>Home</title>
</head>
<body>
	<?php 

		if (isset($_SESSION['user_id'])){
		  include '../navbars/navbar_active.php';}
		else{
		  include '../navbars/navbar_cover.php';
		}
	?>
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class=""></li>
          <li data-target="#myCarousel" data-slide-to="1" class=""></li>
          <li data-target="#myCarousel" data-slide-to="2" class="active"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item">
            <div class="container d-flex align-items-center justify-content-center min-vh-100">
            
              <div class="carousel-caption text-left" id = "last_proj">
               
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container d-flex align-items-center justify-content-center min-vh-100">
            
              <div class="carousel-caption text-left" id="sec_last_proj">
                
              </div>
            </div>
          </div>
          <div class="carousel-item active">
            <div class="container d-flex align-items-center justify-content-center min-vh-100">
            
              <div class="carousel-caption" id = "new_proj">
                <h1>Create a new project</h1>
                <button class="btn btn-primary Redirect"
						onclick="window.location='../projects/new_project.php'">New Project</button>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
</body>
</html>
