$(document).ready(function() {
	
	//load drop down lists
	var countries;
	var proj_types;
	$.when(
		$.ajax({
				type:'post',
				url:'countries.php',
				dataType:'json',
				success: function(data, statusTxt, xmlht){
					countries = data;
				}
		}),

		$.ajax({
				type:'post',
				url:'worktypes.php',
				dataType:'json',
				success: function(data, statusTxt, xmlht){
						proj_types = data;
				}
			})
	).then(function(){
		$.each(countries, function(idx, obj) {
			$('#countries').append($('<option>', { 
				value: obj.iso_code,
				text : obj.country_name
			}));	
		});
		$.each(proj_types, function(idx, obj) {
			$('#proj_type_dropd').append($('<option>', { 
				value: obj.proj_type,
				text : obj.proj_type
			}));
		});
	});

	
	
	//disable next button
	$('#next').prop('disabled',true);
	
	
	/* BUTTON FUNCTIONALITIES */
	$('#save_proj').click(function(){
		alert("The project will be saved!");
		
	});
	
	if (window.location.hash === '#showNext') {
		$('#next').prop('disabled',false);
	}
			
	
	function showNext(){
		$('#next').prop('disabled',false);
	}
	
	$('#next').click(function(){
		alert("This will lead you to the next setup page.");
		//$("#proj_setup").show();
		//$("#new_project").hide();
	});
	
	var cancelForms = document.querySelectorAll('form');
	
	for( var i = 0; i <cancelForms.length; i++){
		cancelForms[i].addEventListener('reset', function(event) {
			if (!confirm('Are you sure you want to reset?')) {
				event.preventDefault();
			}
		});
	}
	
	/*
	document.querySelector('form').addEventListener('reset', function(event) {
		if (!confirm('Are you sure you want to reset?')) {
			event.preventDefault();
	}*/
});

