/**
 * HELIUMFRAMEWORK - FORM HANDLING
 * @author Ahmed Shan (@thaanu16)
 */

var HFForms = document.querySelectorAll('.HFForm');
var waituntil = 1000;

var form_once_submitted = false;

for (var i = 0; i < HFForms.length; i++ ) {
    
    HFForms[i].addEventListener('submit', function (e) {

        e.preventDefault();

        var form = this;
        var form_elements = form.elements;
        var actionURL = form.getAttribute('action');
        var serializedForm = hf_serialize(form);

        var alt_btn = '';
        if ( this.querySelectorAll('.hf-alt-btn').length > 0 ) {
            alt_btn = this.querySelectorAll('.hf-alt-btn')[0];
        }

        // Success Instructions
        var next_action = form.getAttribute('data-na');
        var next_screen = form.getAttribute('data-ns');

        // Elements
        var form_submit_button = form.querySelectorAll('[type=submit]')[0];
        var form_submit_button_default_text = form_submit_button.innerHTML;

        // Disable submit button, once form submitted and change it's text to processing
        form_submit_button.classList.add('disabled');
        form_submit_button.innerHTML = '<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div>';

        form_once_submitted = true;

        // If form once submitted, then reset the error fields
        if ( form_once_submitted == true ) {
            for (var j = 0; j < form.elements.length; j++) {
                // Remove 'is-invalid' class
                form.elements[j].classList.remove('is-invalid');
            }
        }

        // Start creating form data
        var formData = new FormData();
        
        // Handle input['type=file']
        for (var field = 0, form_elements; form_element = form_elements[field++];) {
            
            // Check if there is a file field in the form
            if ( form_element.type == 'file' && form_element.name != undefined && form_element.files.length > 0 ) {
                formData.append(form_element.name, form_element.files[0], form_element.files[0].name);
            }

        }

        // Form Field Handling
        formData.append('data', serializedForm);

        // Prepare to send form data
        var xhr = new XMLHttpRequest();

        xhr.open('POST', actionURL, true);

        // Initialize a return data handler
        xhr.onload = function () {

            // Check if the return status is 200
            if (xhr.status === 200) {

                var responseObject = JSON.parse(xhr.responseText);
                
                // Check if the status is true
                if (responseObject.status === true) {

                    // Redirect to next screen
                    if (next_action == 'redirect-to-next-screen') {
                        window.location.href = next_screen;
                    }

                    // Show success message and redirect to next screen
                    if (next_action == 'success-then-redirect-to-next-screen') {
                        hf_show_success_msg( responseObject.textMessage );
                        setTimeout(function () { 
                            window.location.href = next_screen;
                        }, waituntil);
                    }

                    // Show success message and redirect to next screen requested by API
                    if (next_action == 'success-then-redirect-to-next-screen-server') {
                        hf_show_success_msg( responseObject.textMessage );
                        setTimeout(function () { 
                            window.location.href = responseObject.data_ns;
                        }, waituntil);
                    }

                    // Show success message and redirect to next screen
                    if (next_action == 'success-then-do-nothing') {
                        hf_show_success_msg(responseObject.textMessage, waituntil + waituntil);
                        setTimeout(function () { 
                            alt_btn.innerHTML = 'Done';
                        }, waituntil);
                    }
                    
                }
                // Else, if response status not true
                else {

                    // Check for form error fields
                    if (responseObject.error_fields.length > 0) {
                        
                        for (var f = 0; f < responseObject.error_fields.length; f++) {
                            hf_error_toast(responseObject.error_fields[f].message);
                            var elem = responseObject.error_fields[f].field;
                            document.getElementById(elem).classList.add('is-invalid');
                        }

                    }
                    
                    // Show other errors
                    if (responseObject.errors.length > 0) {
                            
                        // Handle only 1 error
                        if (responseObject.errors.length == 1) {
                            hf_show_error_msg( responseObject.errors[0] );
                        }
                        // Else, more than 1 error
                        else {
                            // Show toastr
                            for (var f = 0; f < responseObject.errors.length; f++) {
                                hf_error_toast(responseObject.errors[f]);
                            }
                        }

                    } 


                }

            }
            // Else, show error
            else {
                hf_show_error_msg( 'Something internally went wrong' );
            }

            // Re-enable submit button and change the text back to it's default
            form_submit_button.classList.remove('disabled');
            form_submit_button.innerHTML = form_submit_button_default_text;


        }

        // Send Data
        xhr.send(formData);

    });

}


/**
 * Form Serializer
 */
function hf_serialize (form) {

	// Setup our serialized data
	var serialized = [];

	// Loop through each field in the form
	for (var i = 0; i < form.elements.length; i++) {

		var field = form.elements[i];

		// Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
		if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

		// If a multi-select, get all selections
		if (field.type === 'select-multiple') {
			for (var n = 0; n < field.options.length; n++) {
				if (!field.options[n].selected) continue;
				serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[n].value));
			}
		}

		// Convert field data to a query string
		else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
			serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
		}
	}

	return serialized.join('&');

};
