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
	
	
	var my_orms = document.querySelectorAll('form');
	
	for( var i = 0; i <my_forms.length; i++){
		my_forms[i].addEventListener('reset', function(event) {
			if (!confirm('Are you sure you want to reset?')) {
				event.preventDefault();
			}
        });
        
		my_forms[i].addEventListener('submit', function(event) {
			if (!confirm('Please confirm you want to create the project.')) {
				event.preventDefault();
			}
		});
    }
    
});

