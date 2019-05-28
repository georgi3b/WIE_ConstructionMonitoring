$(document).ready(function() {
	
	var json_proj;
	
	$.when(
			//get all the projects for the given user
			$.ajax({
				type:'post',
				url:'../projects/user_projects_controller.php',
				dataType:'json',
				success: function(data, statusTxt, xmlht){
					json_proj = data;
				}
		})
	).then(function(){

		if(window.location.hash == '#active'){
			$.each(json_proj, function(idx, obj) {
			//give only the results with active = true
			 if(obj.active==='true'||obj.active){
	    		 $('<tr>').attr('id',obj.proj_id).
	    		 append($('<td>').text(obj.proj_id)).
	    		  append($('<td>').text(obj.proj_name)).
	    		  append($('<td>').text(obj.active)).
	    		  append($('<td>').text(obj.proj_type)).
	    		  append($('<td>').text(obj.company)).
	    		  append($('<td>').
	    		  append($('<form>'). attr({'method':'post','action':'../projects/project_info.php'})
	    		  .append($('<input>').attr({'name':'id','value':obj.proj_id}))
	    		  .append($('<input>').attr({'name':'info','type': 'submit','class':'btn btn-outline-primary'}).val("more info"))
	    			 )).appendTo("tbody#projects");
	    		//append data to tbody with id "projects"
	        	$('<td>').
	        			append($('<form>').attr({'method':'post','action':'../monitoring/monitoring.php'})
	        			.append($('<input>').attr({'name':'id','value':obj.proj_id}))
	        			.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn btn-outline-primary'}).val("monitor"))).
	        			appendTo("tr#"+obj.proj_id);
	    	
				}				
			});
		}
		else{
		
        	$.each(json_proj, function(idx, obj) {
    
        		 $('<tr>').attr('id',obj.proj_id).
        		 append($('<td>').text(obj.proj_id)).
        		  append($('<td>').text(obj.proj_name)).
        		  append($('<td>').text(obj.active)).
        		  append($('<td>').text(obj.proj_type)).
        		  append($('<td>').text(obj.company)).
        		  append($('<td>').
        		  append($('<form>'). attr({'method':'post','action':'../projects/project_info.php'})
        		  .append($('<input>').attr({'name':'id','value':obj.proj_id}))
        		  .append($('<input>').attr({'name':'info','type': 'submit','class':'btn btn-outline-primary'}).val("more info"))
        			 )).appendTo("tbody#projects");
        		//append data to tbody with id "projects"
        		if(obj.active==='true'||obj.active){
            		$('<td>').
            			append($('<form>').attr({'method':'post','action':'../monitoring/monitoring.php'})
            			.append($('<input>').attr({'name':'id','value':obj.proj_id}))
            			.append($('<input>').attr({'name':'mon','type': 'submit','class':'btn btn-outline-primary'}).val("monitor"))).
            			appendTo("tr#"+obj.proj_id);
        		} else {
        			$('<td>').text("Archived").appendTo("tr#"+obj.proj_id);
            	}
							
			});
		}
    	$('input[name="id"]').hide();
	});
			
});