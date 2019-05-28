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
		//if the user has already created at least two projects
		if(allProj.length>=1){
		
    		last = allProj[allProj.length-1];
    		//alert(last);
    		$('<h1>').attr({'value':'Project ' + last.proj_id})
    					.text('Project ' + last.proj_id + ": " + last.proj_name).appendTo('#last_proj');
    		$('<p>').text(last.description).appendTo('#last_proj');
    		$('<form>').attr({'method':'post','action':'../projects/project_info.php'})
    		.append($('<input>').attr({'name':'id','value':last.proj_id,'type':'hidden'}))
    		.append($('<input>').attr({'name':'info','type': 'submit','class':'btn btn-primary'}).val("more info"))
    		  .appendTo('#last_proj');
    
    		if(allProj.length>=2){
        		sec_last = allProj[allProj.length-2];
        		//alert(last);
        
        		$('<h1>').attr({'value':'Project ' + sec_last.proj_id})
        					.text('Project ' + sec_last.proj_id + ": " + sec_last.proj_name).appendTo('#sec_last_proj');
        
        		$('<p>').text(sec_last.description).appendTo('#sec_last_proj');
        
        		$('<form>').attr({'method':'post','action':'../projects/project_info.php'})
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
		

});