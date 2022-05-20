
function submitForm(){
	$.ajax({
	   type: "POST",
	   url: "update_profile.php",
	   cache:false,
	   data: $('form#edit-form').serialize(),
	   success: function(response){
		   $("#contact").html(response)
		   $("#modal_usuario").modal('hide');
	   },
	   error: function(){
		   alert("Error");
	   }
   });
} 