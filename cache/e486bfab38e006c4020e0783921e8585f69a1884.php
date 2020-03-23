<?php $__env->startSection('page_title', 'Flights'); ?>
<?php $__env->startSection('page_content'); ?>

<div id="flight_info" class="card card-default color-palette-box">
    <div class="card-body">
        LOADING FLIGHTS...
    </div>
    <!-- /.card-body -->
</div>

<script>
    $(document).ready(function(){
        var displayBox = $('#flight_info').find('.card-body');
        $.ajax({
            url: '/flights/allflights',
            method: 'GET',
            error: function(){
                displayBox.html("An error occured");
            },
            success: function( data ){
                displayBox.html(data);
            }
        });

        setInterval(function(){
            $.ajax({
                url: '/flights/allflights',
                method: 'GET',
                error: function(){
                    displayBox.html("An error occured");
                },
                success: function( data ){
                    displayBox.html(data);
                }
            });
        }, 10000);
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/flightsmv/views/cpanel/flights/show.blade.php ENDPATH**/ ?>