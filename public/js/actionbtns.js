$(document).ready(function () {

    var preloader = '<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';

    var req_ac_btns = $('.req-ac-button');

    if (req_ac_btns.length > 0) {

        $.each(req_ac_btns, function (i, item) {
            var btn = $(item);
            var act = btn.data('action');

            // Initially show preloader
            btn.html(preloader);

            $.get(act, function (data) {
                
                var json = $.parseJSON(data);

                // Completed
                if (json.pr_status == 0) {
                    btn.addClass('disabled');
                    btn.html('Completed');
                }

                // Waiting for HOD Signature
                if (json.pr_status == 1) {
                    btn.data('action', '/pr/mark/' + json.prid + '/2');
                    btn.html('Mark as sent for HOD signature');
                }

                // Waiting for procurement department
                if (json.pr_status == 2) {
                    btn.data('action', '/pr/mark/' + json.prid + '/3');
                    btn.html('Mark as sent to procurement department');
                }

                // Mark as complete
                if (json.pr_status == 3) {
                    btn.data('action', '/pr/mark/' + json.prid + '/0');
                    btn.html('Mark as completed');
                }


            });
        });
    }

    $(document).on('click', '.req-ac-button', function (e) { 
        e.preventDefault();

        var btn = $(this);
        var act = btn.data('action');

        // Initially show preloader
        btn.html(preloader);

        $.get(act, function (data) {
            var json = $.parseJSON(data);

            // Completed
            if (json.pr_status == 0) {
                btn.addClass('disabled');
                btn.html('Completed');
            }

            // Waiting for HOD Signature
            if (json.pr_status == 1) {
                btn.data('action', '/pr/mark/' + json.prid + '/2');
                btn.html('Mark as sent for HOD signature');
            }

            // Waiting for procurement department
            if (json.pr_status == 2) {
                btn.data('action', '/pr/mark/' + json.prid + '/3');
                btn.html('Mark as sent to procurement department');
            }

            // Mark as complete
            if (json.pr_status == 3) {
                btn.data('action', '/pr/mark/' + json.prid + '/0');
                btn.html('Mark as completed');
            }

            // Change Status
            btn.parent().find('.badge').html(json.status_msg);

        });

    });

 });