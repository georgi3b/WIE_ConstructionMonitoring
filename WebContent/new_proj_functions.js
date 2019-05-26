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
				url:'proj_types.php',
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
    
});

