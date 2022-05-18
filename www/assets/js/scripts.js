
function resetForm(selector) {
	$(selector)[0].reset();
}

function update() {
	$("#btnUpdateSubmit").on("click", function () {
		var $this = $(this); //submit button selector using ID
		var $caption = $this.html();// We store the html content of the submit button
		var form = $('#edit-form');
		var formData = new FormData($('#edit-form')[0]);//serialize the form into array
		var route = $(form).attr('action'); //get the route using attribute action

		// Ajax config
		$.ajax({
			type: "POST", //we are using POST method to submit the data to the server side
			url: route, // get the route value
			data: formData,
			cache: false,
			contentType: false,
			processData: false, // our serialized array data for server side
			beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
				$this.attr('disabled', true).html("Processing...");
			},
			success: function (response) {//once the request successfully process to the server side it will return result here
				$this.attr('disabled', false).html($caption);



				// We will display the result using alert
				alert(response);

				// Reset form
				resetForm(form);

				// Close modal
				$('#modal_usuario').modal('toggle');
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				// You can put something here if there is an error from submitted request
			}
		});
	});
}


$(document).ready(function () {

	// Updating the data
	update();
});