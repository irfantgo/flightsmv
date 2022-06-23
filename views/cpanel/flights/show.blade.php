@extends('cpanel.cpanel')
@section('page_title', 'Flights')
@section('page_content')

<div id="flight_info">
    <center>
        <i class="fas fa-spin fa-spinner"></i>
        LOADING FLIGHTS...
    </center>
</div>

<script>
    $(document).ready(function(){
        var displayBox = $('#flight_info');
        
        function fetchFlights() {
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
        }

        fetchFlights();

        setInterval(function(){
            fetchFlights();
        }, 10000);

        function markToRemind( flightId )
        {
            $.post('/flights/mark-to-remind');
        }
        
    });
</script>

@endsection