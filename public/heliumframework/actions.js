/**
 * ACTION BUTTONS
 * @author Ahmed Shan (@thaanu16)
 */
var HFActionBtns = document.querySelectorAll('.HFActionBtn');
if (HFActionBtns.length > 0) {
    
    for (var i = 0; i < HFActionBtns.length; i++ ) {

        // Add event listener
        HFActionBtns[i].addEventListener('click', function (event) {
            
            // Override the default action
            event.preventDefault();

            var actionBtn = this;
            var action = actionBtn.getAttribute('href');
            var next_screen = actionBtn.getAttribute('data-ns');

            swal({
                title: actionBtn.getAttribute('data-title'),
                text: actionBtn.getAttribute('data-text'),
                type: actionBtn.getAttribute('data-type'),
                dangerMode: true,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: "Continue",
                closeOnConfirm: false
            }, function () { 
                    
                // Purform the action
                var xyz = new XMLHttpRequest();
                    
                xyz.open('GET', action, true);
                
                xyz.onload = function () {
                        // Check if the return status is 200
                    if (xyz.status === 200) {

                        var responseObject = JSON.parse(xyz.responseText);   
                         
                        // Check if the results status is true
                        if (responseObject.status === true) {

                            // swal("Alright", responseObject.textMessage, "success");
                            swal({
                                title: 'Alright!',
                                text: responseObject.textMessage,
                                type: 'success',
                                showConfirmButton: true,
                                confirmButtonText: "Ok",
                                closeOnConfirm: true
                            }, function () { 
                                    
                                window.location.href = next_screen;                                
                                
                            });
                            
                        }
                        // Else, show error message
                        else {
                            if (responseObject.errors.length == 1) {
                                swal("Whoops!!", responseObject.errors[0], "error");
                            }
                        }

                    }
                    else {
                        // Something internally went wrong
                        swal("Whoops!", "Something internally went wrong", "error");
                    }

                }
                    
                xyz.send();
                    
                
            });

            // swal({
            //     title: "Are you sure?",
            //     text: "Your will not be able to recover this imaginary file!",
            //     type: "warning",
            //     showCancelButton: true,
            //     confirmButtonClass: "btn-danger",
            //     confirmButtonText: "Yes, delete it!",
            //     closeOnConfirm: false
            //   },
            //   function(){
            //     swal("Deleted!", "Your imaginary file has been deleted.", "success");
            //   });



            console.log(action);

        });

    }

}