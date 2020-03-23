// Success Message
// tmr : given in ms for auto dismiss
function hf_show_success_msg(text, tmr = null) {  
    swal({
        title: 'Success',
        text: text,
        type: "success",
        timer: tmr,
        showConfirmButton: false
    });
}

// Error Message
// tmr : given in ms for auto dismiss
function hf_show_error_msg(text, tmr = null) {  
    swal({
        title: 'Whoops',
        text: text,
        type: "error",
        timer: tmr,
        showConfirmButton: true
    });
}

// Warning Message
// tmr : given in ms for auto dismiss
function hf_show_warning_msg(text, tmr = null) {  
    swal({
        title: 'Whoops',
        text: text,
        type: "error",
        timer: tmr,
        showConfirmButton: true
    });
}

// Success Toast
function hf_success_toast(text)
{
    toastr.success(text)
}

// Error Toast
function hf_error_toast(text)
{
    toastr.error(text)
}

// Warning Toast
function hf_warning_toast(text)
{
    toastr.warning(text)
}

// Info Toast
function hf_info_toast(text)
{
    toastr.info(text)
}
