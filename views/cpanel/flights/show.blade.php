@extends('cpanel.cpanel')
@section('page_title', 'Flights')
@section('page_content')

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

@endsection